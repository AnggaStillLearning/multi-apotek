<?php

namespace App\Http\Controllers;

use App\Exceptions\StokTidakCukupException;
use App\Models\KonversiObat;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Services\StokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Pembelian offline: kasir input langsung untuk pembeli walk-in
 * (dengan/tanpa akun). Tabelnya sama dengan Pembelian online
 * (`pembelians`, `jenis=offline`), tapi TIDAK lewat Pemesanan sama sekali
 * — beda dari alur online yang keranjangnya tersimpan sebagai draft
 * Pemesanan di database, di sini kasir mengumpulkan item transaksi
 * langsung di halaman (di sisi klien/JS), lalu semuanya dikirim jadi satu
 * kali submit ke store().
 *
 * Beda paling penting dari alur online: karena pembayaran terjadi tunai/
 * kartu di depan kasir saat itu juga (bukan lewat Midtrans), tidak ada
 * status "menunggu_pembayaran" — begitu disimpan, transaksi langsung
 * berstatus "selesai" dan stok langsung dikurangi lewat FEFO (StokService),
 * dalam satu DB::transaction yang sama dengan pembuatan header & detail.
 */
class PembelianOfflineController extends Controller
{
    public function index(Request $request)
    {
        $pembelians = Pembelian::where('apotek_id', Auth::user()->apotek_id)
            ->where('jenis', 'offline')
            ->with('kasir')
            ->when($request->filled('search'), fn ($q) => $q->where(
                'nomor_pembelian',
                'like',
                '%' . $request->search . '%'
            ))
            ->latest('tanggal_pembelian')
            ->paginate(15)
            ->withQueryString();

        return view('pembelian.offline.index', compact('pembelians'));
    }

    public function create()
    {
        return view('pembelian.offline.create');
    }

    public function show(Pembelian $pembelian)
    {
        if ($pembelian->apotek_id !== Auth::user()->apotek_id) {
            abort(403);
        }

        $pembelian->load([
            'kasir',
            'details.obat',
            'details.konversi.satuan',
            'details.batch',
        ]);

        return view('pembelian.offline.show', compact('pembelian'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:obats,id',
            'items.*.konversi_obat_id' => 'required|exists:konversi_obats,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $apotekId = Auth::user()->apotek_id;

        // Validasi obat & konversi memang benar-benar milik apotek kasir
        // ini, dan stok mencukupi, sebelum apa pun disimpan.
        foreach ($validated['items'] as $item) {

            $obat = Obat::find($item['obat_id']);

            if (!$obat || $obat->apotek_id !== $apotekId) {
                return back()->withInput()->with(
                    'error',
                    'Salah satu obat tidak ditemukan di apotek ini.'
                );
            }

            $konversi = KonversiObat::where('obat_id', $obat->id)
                ->find($item['konversi_obat_id']);

            if (!$konversi) {
                return back()->withInput()->with(
                    'error',
                    "Satuan yang dipilih untuk {$obat->nama_obat} tidak valid."
                );
            }

            if (!$obat->cukupStok($konversi->id, $item['qty'])) {
                return back()->withInput()->with(
                    'error',
                    "Stok {$obat->nama_obat} tidak mencukupi."
                );
            }
        }

        try {

            $pembelian = DB::transaction(function () use ($validated, $apotekId) {

                $stokService = new StokService();

                $pembelian = Pembelian::create([
                    'apotek_id' => $apotekId,
                    'pemesanan_id' => null,
                    'user_id' => null,
                    'kasir_id' => Auth::id(),
                    'nomor_pembelian' => $this->generateNomorPembelian(),
                    'jenis' => 'offline',
                    'tanggal_pembelian' => now(),
                    'subtotal' => 0,
                    'grand_total' => 0,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'status' => 'selesai',
                ]);

                $grandTotal = 0;

                foreach ($validated['items'] as $item) {

                    $obat = Obat::findOrFail($item['obat_id']);
                    $konversi = KonversiObat::findOrFail($item['konversi_obat_id']);
                    $qty = $item['qty'];

                    $qtyDasar = $qty * $konversi->isi;

                    $diambilDari = $stokService->kurangiStok(
                        $obat->id,
                        $qtyDasar
                    );

                    // Sama seperti di alur online: kalau FEFO menyentuh
                    // lebih dari 1 batch, traceability disederhanakan ke
                    // batch pertama (paling dekat kadaluarsa) — lihat
                    // catatan di PembelianOnlineController.
                    $batchPertama = $diambilDari->first()['batch'];

                    $subtotal = $qty * $konversi->harga_jual;
                    $grandTotal += $subtotal;

                    PembelianDetail::create([
                        'pembelian_id' => $pembelian->id,
                        'obat_id' => $obat->id,
                        'konversi_obat_id' => $konversi->id,
                        'batch_obat_id' => $batchPertama->id,
                        'qty' => $qty,
                        'isi' => $konversi->isi,
                        'harga_beli' => $batchPertama->harga_beli,
                        'harga_jual' => $konversi->harga_jual,
                        'subtotal' => $subtotal,
                    ]);
                }

                $pembelian->update([
                    'subtotal' => $grandTotal,
                    'grand_total' => $grandTotal,
                ]);

                return $pembelian;
            });

        } catch (StokTidakCukupException $e) {

            // Edge case: stok berubah di antara pengecekan awal dan saat
            // transaksi benar-benar dijalankan (mis. kasir lain di apotek
            // yang sama memproses transaksi bersamaan).
            return back()->withInput()->with(
                'error',
                'Stok tidak mencukupi: ' . $e->getMessage()
            );

        }

        return redirect()
            ->route('pembelian.offline.show', $pembelian)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    private function generateNomorPembelian(): string
    {
        $tanggal = now()->format('Ymd');

        $last = Pembelian::whereDate('created_at', today())->count() + 1;

        return 'PMB-' . $tanggal . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
