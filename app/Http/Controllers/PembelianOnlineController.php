<?php

namespace App\Http\Controllers;

use App\Exceptions\StokTidakCukupException;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Pemesanan;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Pembelian online: checkout dari Pemesanan (keranjang) sampai selesai.
 *
 * Alur status: menunggu_pembayaran -> diproses -> selesai
 *                                   -> dibatalkan
 *
 * Pembayaran memakai Midtrans Snap (popup). Status yang jadi acuan resmi
 * datang dari webhook server-to-server Midtrans (notifikasi()), bukan dari
 * JS callback di browser — supaya tidak bisa dipalsukan dari sisi client.
 * Stok BARU dikurangi (FEFO, lewat StokService) saat status naik ke
 * "diproses", bukan saat checkout/menunggu_pembayaran — sesuai keputusan
 * desain Fase 1, supaya barang yang belum dibayar tidak mengunci stok
 * pembeli lain.
 */
class PembelianOnlineController extends Controller
{
    /**
     * "Pesanan saya" — daftar pembelian online milik pembeli yang login.
     */
    public function index()
    {
        $pembelians = Pembelian::where('user_id', Auth::id())
            ->where('jenis', 'online')
            ->with('apotek')
            ->latest('tanggal_pembelian')
            ->paginate(10);

        return view('pembelian.online.index', compact('pembelians'));
    }

    public function show(Pembelian $pembelian)
    {
        $this->authorizeAkses($pembelian);

        $pembelian->load([
            'apotek',
            'pemesanan',
            'details.obat',
            'details.konversi.satuan',
            'details.batch',
        ]);

        $snapToken = null;

        if ($pembelian->status === 'menunggu_pembayaran') {
            $snapToken = $this->getSnapToken($pembelian);
        }

        return view('pembelian.online.show', compact('pembelian', 'snapToken'));
    }

    /**
     * Checkout: ubah keranjang (Pemesanan draft) jadi 1 baris Pembelian
     * berstatus menunggu_pembayaran. Belum menyentuh stok sama sekali.
     */
    public function store(Request $request, Pemesanan $pemesanan)
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses ke keranjang ini.');
        }

        if ($pemesanan->status !== 'draft') {
            return back()->with(
                'error',
                'Keranjang ini sudah pernah di-checkout.'
            );
        }

        if ($pemesanan->details()->count() === 0) {
            return back()->with(
                'error',
                'Keranjang masih kosong.'
            );
        }

        $validated = $request->validate([
            'metode_pembayaran' => 'nullable|string|max:50',
        ]);

        // Stok bisa saja sudah berubah sejak barang dimasukkan ke keranjang,
        // jadi dicek ulang di sini sebelum Pembelian benar-benar dibuat.
        foreach ($pemesanan->details as $detail) {
            if (!$detail->obat->cukupStok($detail->konversi_obat_id, $detail->qty)) {
                return back()->with(
                    'error',
                    "Stok {$detail->obat->nama_obat} sudah tidak mencukupi, silakan sesuaikan keranjang."
                );
            }
        }

        $pembelian = DB::transaction(function () use ($pemesanan, $validated) {

            $pembelian = Pembelian::create([
                'apotek_id' => $pemesanan->apotek_id,
                'pemesanan_id' => $pemesanan->id,
                'user_id' => Auth::id(),
                'kasir_id' => null,
                'nomor_pembelian' => $this->generateNomorPembelian(),
                'jenis' => 'online',
                'tanggal_pembelian' => now(),
                'subtotal' => $pemesanan->subtotal,
                'grand_total' => $pemesanan->grand_total,
                'metode_pembayaran' => $validated['metode_pembayaran'] ?? null,
                'status' => 'menunggu_pembayaran',
            ]);

            foreach ($pemesanan->details as $detail) {

                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'obat_id' => $detail->obat_id,
                    'konversi_obat_id' => $detail->konversi_obat_id,
                    'batch_obat_id' => null,
                    'qty' => $detail->qty,
                    'isi' => $detail->konversi->isi,
                    'harga_beli' => null,
                    'harga_jual' => $detail->harga_jual,
                    'subtotal' => $detail->subtotal,
                ]);
            }

            $pemesanan->update(['status' => 'checkout']);

            return $pembelian;
        });

        return redirect()
            ->route('pembelian.online.show', $pembelian)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
     * Ambil Snap token dari Midtrans untuk pesanan ini. Dibuat baru setiap
     * halaman dibuka (bukan disimpan di kolom DB) supaya tidak perlu migrasi
     * tambahan dan tidak ada risiko token kedaluwarsa yang tersimpan basi.
     * Kalau kredensial belum diisi di .env atau Midtrans sedang bermasalah,
     * kembalikan null saja — halaman tetap tampil, cuma tombol Snap-nya
     * tidak muncul (fallback manual di bawah tetap bisa dipakai untuk testing).
     */
    private function getSnapToken(Pembelian $pembelian): ?string
    {
        if (!config('services.midtrans.server_key')) {
            return null;
        }

        try {

            $this->configureMidtrans();

            $params = [
                'transaction_details' => [
                    'order_id' => $pembelian->nomor_pembelian,
                    'gross_amount' => (int) $pembelian->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $pembelian->user->name,
                    'email' => $pembelian->user->email,
                ],
                'item_details' => $pembelian->details->map(fn ($detail) => [
                    'id' => $detail->id,
                    'name' => substr($detail->obat->nama_obat, 0, 50),
                    'quantity' => $detail->qty,
                    'price' => (int) $detail->harga_jual,
                ])->all(),
            ];

            return \Midtrans\Snap::getSnapToken($params);

        } catch (\Throwable $e) {

            Log::error('Gagal membuat Snap token Midtrans: ' . $e->getMessage());

            return null;

        }
    }

    private function configureMidtrans(): void
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = (bool) config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    /**
     * Webhook server-to-server Midtrans. Ini satu-satunya tempat yang
     * dipercaya untuk menaikkan status pembayaran, karena dipanggil
     * langsung oleh server Midtrans (bukan dari browser pembeli) dan
     * diverifikasi pakai signature key — tidak bisa dipalsukan dari sisi
     * client. Route-nya dikecualikan dari CSRF (lihat bootstrap/app.php)
     * karena bukan request dari browser.
     *
     * Perlu URL yang bisa diakses publik (mis. lewat ngrok saat development)
     * supaya Midtrans bisa menghubungi endpoint ini; kalau tidak,
     * pakai tombol fallback manual di bayar() untuk demo/testing lokal.
     */
    public function notifikasi(Request $request)
    {
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $paymentType = $request->input('payment_type');

        $serverKey = config('services.midtrans.server_key');

        $signatureValid = $signatureKey === hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . $serverKey
        );

        if (!$signatureValid) {
            Log::warning("Notifikasi Midtrans ditolak: signature tidak valid untuk order {$orderId}.");

            return response()->json(['message' => 'invalid signature'], 403);
        }

        $pembelian = Pembelian::where('nomor_pembelian', $orderId)->first();

        if (!$pembelian) {
            return response()->json(['message' => 'order not found'], 404);
        }

        if ($pembelian->status !== 'menunggu_pembayaran') {
            // Sudah diproses sebelumnya (notifikasi Midtrans bisa terkirim
            // lebih dari sekali) — jangan potong stok dua kali.
            return response()->json(['message' => 'already handled']);
        }

        if (
            $transactionStatus === 'capture' && $fraudStatus === 'accept'
            || $transactionStatus === 'settlement'
        ) {

            try {
                $this->tandaiSudahDibayar($pembelian, $paymentType);
            } catch (StokTidakCukupException $e) {
                Log::error("Stok tidak cukup saat memproses pembayaran order {$orderId}: " . $e->getMessage());

                return response()->json(['message' => 'insufficient stock'], 409);
            }

        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {

            $pembelian->update(['status' => 'dibatalkan']);

        }
        // 'pending' -> dibiarkan, tetap menunggu_pembayaran sampai notifikasi berikutnya.

        return response()->json(['message' => 'ok']);
    }

    /**
     * Fallback manual untuk demo/testing lokal saat webhook Midtrans belum
     * bisa diakses (mis. belum pasang ngrok). TIDAK untuk dipakai di
     * production — di production, status pembayaran hanya boleh berubah
     * lewat notifikasi() di atas.
     */
    public function bayar(Request $request, Pembelian $pembelian)
    {
        $this->authorizeAkses($pembelian);

        if ($pembelian->status !== 'menunggu_pembayaran') {
            return back()->with(
                'error',
                'Pesanan ini sudah tidak berstatus menunggu pembayaran.'
            );
        }

        $validated = $request->validate([
            'metode_pembayaran' => 'nullable|string|max:50',
        ]);

        try {

            $this->tandaiSudahDibayar($pembelian, $validated['metode_pembayaran'] ?? 'manual (dev)');

        } catch (StokTidakCukupException $e) {

            return back()->with(
                'error',
                'Pembayaran gagal diproses: ' . $e->getMessage() . ' Silakan hubungi apotek.'
            );

        }

        return back()->with(
            'success',
            'Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses.'
        );
    }

    /**
     * Logic inti saat pembayaran dinyatakan sukses — dipanggil dari webhook
     * Midtrans (notifikasi()) maupun tombol fallback manual (bayar()).
     * Di sinilah stok benar-benar dikurangi lewat FEFO (StokService,
     * Fase 2), lalu status naik ke "diproses".
     *
     * Catatan penyederhanaan: kalau FEFO mengambil dari lebih dari 1 batch
     * untuk memenuhi 1 baris item, pengurangan stok fisik tetap akurat di
     * semua batch yang terpakai — hanya kolom `batch_obat_id` di baris itu
     * yang dicatat merujuk ke batch pertama (paling dekat kadaluarsa) demi
     * kesederhanaan traceability. Detail penuh lintas-batch belum disimpan;
     * bisa ditindaklanjuti di Fase 9/10 kalau dibutuhkan.
     *
     * @throws StokTidakCukupException
     */
    private function tandaiSudahDibayar(Pembelian $pembelian, ?string $metodePembayaran): void
    {
        DB::transaction(function () use ($pembelian, $metodePembayaran) {

            $stokService = new StokService();

            foreach ($pembelian->details as $detail) {

                $qtyDasar = $detail->qty * $detail->isi;

                $diambilDari = $stokService->kurangiStok(
                    $detail->obat_id,
                    $qtyDasar
                );

                $batchPertama = $diambilDari->first()['batch'];

                $detail->update([
                    'batch_obat_id' => $batchPertama->id,
                    'harga_beli' => $batchPertama->harga_beli,
                ]);
            }

            $pembelian->update([
                'status' => 'diproses',
                'metode_pembayaran' => $metodePembayaran ?? $pembelian->metode_pembayaran,
            ]);
        });
    }

    /**
     * Tandai pesanan selesai (barang sudah diambil/diterima pembeli).
     * Dilakukan oleh admin apotek/kasir, bukan pembeli.
     */
    public function selesai(Pembelian $pembelian)
    {
        if ($pembelian->status !== 'diproses') {
            return back()->with(
                'error',
                'Pesanan ini belum berstatus diproses.'
            );
        }

        $pembelian->update(['status' => 'selesai']);

        return back()->with(
            'success',
            'Pesanan ditandai selesai.'
        );
    }

    /**
     * Pembeli membatalkan pesanan. Hanya diizinkan sebelum pembayaran
     * dikonfirmasi (status menunggu_pembayaran), karena setelah itu stok
     * sudah terlanjur dikurangi dan pengembalian stok belum diimplementasikan.
     */
    public function batal(Pembelian $pembelian)
    {
        $this->authorizeAkses($pembelian);

        if ($pembelian->status !== 'menunggu_pembayaran') {
            return back()->with(
                'error',
                'Pesanan yang sudah dibayar tidak dapat dibatalkan sendiri, silakan hubungi apotek.'
            );
        }

        $pembelian->update(['status' => 'dibatalkan']);

        return back()->with(
            'success',
            'Pesanan berhasil dibatalkan.'
        );
    }

    private function authorizeAkses(Pembelian $pembelian): void
    {
        $user = Auth::user();

        $bolehAdmin = in_array($user->role, ['admin_apotek', 'kasir', 'super_admin']);

        if ($pembelian->user_id !== $user->id && !$bolehAdmin) {
            abort(403, 'Anda tidak memiliki hak akses ke pesanan ini.');
        }
    }

    private function generateNomorPembelian(): string
    {
        $tanggal = now()->format('Ymd');

        $last = Pembelian::whereDate('created_at', today())->count() + 1;

        return 'PMB-' . $tanggal . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
