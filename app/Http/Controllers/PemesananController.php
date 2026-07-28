<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use App\Models\KonversiObat;
use App\Models\Obat;
use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Keranjang online. Berbeda dari toko biasa, keranjang di sini disimpan
 * sebagai baris `Pemesanan` (status draft) + `PemesananDetail` di database,
 * BUKAN di session, supaya konsisten dengan keputusan desain Fase 1: satu
 * baris Pemesanan draft = satu keranjang aktif milik satu pembeli untuk
 * satu apotek. Checkout-nya sendiri (jadi Pembelian) ditangani oleh
 * PembelianOnlineController.
 */
class PemesananController extends Controller
{
    /**
     * "Keranjang saya" — arahkan ke keranjang draft yang sedang aktif.
     * Karena keranjang di sini per-apotek, seorang pembeli bisa saja
     * punya lebih dari satu keranjang draft (belanja di 2 apotek berbeda).
     */
    public function index()
    {
        $pemesanans = Pemesanan::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->with('apotek')
            ->withCount('details')
            ->latest('updated_at')
            ->get();

        if ($pemesanans->count() === 1) {
            return redirect()->route('pemesanan.show', $pemesanans->first());
        }

        return view('pemesanan.index', compact('pemesanans'));
    }

    /**
     * Tampilkan isi satu keranjang.
     */
    public function show(Pemesanan $pemesanan)
    {
        $this->authorizeOwner($pemesanan);

        $pemesanan->load([
            'apotek',
            'details.obat',
            'details.konversi.satuan',
        ]);

        return view('pemesanan.show', compact('pemesanan'));
    }

    /**
     * Tambah 1 obat (dengan konversi default-nya) ke keranjang apotek
     * terkait. Kalau baris obat+konversi yang sama sudah ada, qty tinggal
     * ditambah — meniru perilaku addToCart() versi lama.
     */
    public function store(Request $request, Apotek $apotek, Obat $obat)
    {
        if ($obat->apotek_id !== $apotek->id) {
            abort(404);
        }

        $validated = $request->validate([
            'konversi_obat_id' => 'nullable|exists:konversi_obats,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $konversi = isset($validated['konversi_obat_id'])
            ? KonversiObat::where('obat_id', $obat->id)->findOrFail($validated['konversi_obat_id'])
            : $obat->konversis()->where('is_default', true)->first()
                ?? $obat->konversis()->orderBy('urutan')->first();

        if (!$konversi) {
            return back()->with(
                'error',
                'Obat ini belum punya satuan/konversi yang bisa dijual.'
            );
        }

        $qtyTambahan = $validated['qty'] ?? 1;

        try {

            DB::transaction(function () use ($apotek, $obat, $konversi, $qtyTambahan) {

                $pemesanan = Pemesanan::firstOrCreate(
                    [
                        'apotek_id' => $apotek->id,
                        'user_id' => Auth::id(),
                        'status' => 'draft',
                    ],
                    [
                        'nomor_pemesanan' => $this->generateNomorPemesanan(),
                        'tanggal_pemesanan' => now(),
                        'subtotal' => 0,
                        'grand_total' => 0,
                    ]
                );

                $detail = $pemesanan->details()
                    ->where('obat_id', $obat->id)
                    ->where('konversi_obat_id', $konversi->id)
                    ->first();

                $qtyBaru = ($detail->qty ?? 0) + $qtyTambahan;

                if (!$obat->cukupStok($konversi->id, $qtyBaru)) {
                    throw new \RuntimeException('Jumlah melebihi stok yang tersedia.');
                }

                if ($detail) {
                    $detail->update([
                        'qty' => $qtyBaru,
                        'subtotal' => $qtyBaru * $detail->harga_jual,
                    ]);
                } else {
                    PemesananDetail::create([
                        'pemesanan_id' => $pemesanan->id,
                        'obat_id' => $obat->id,
                        'konversi_obat_id' => $konversi->id,
                        'qty' => $qtyBaru,
                        'harga_jual' => $konversi->harga_jual,
                        'subtotal' => $qtyBaru * $konversi->harga_jual,
                    ]);
                }

                $this->recalculateTotal($pemesanan);
            });

        } catch (\RuntimeException $e) {

            return back()->with('error', $e->getMessage());

        }

        return back()->with(
            'success',
            'Obat berhasil ditambahkan ke keranjang.'
        );
    }

    /**
     * Pastikan hanya pemilik keranjang yang bisa melihat/mengubahnya.
     * Tidak pakai Policy karena project ini belum memakainya di modul lain.
     */
    private function authorizeOwner(Pemesanan $pemesanan): void
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses ke keranjang ini.');
        }
    }

    public static function recalculateTotal(Pemesanan $pemesanan): void
    {
        $subtotal = $pemesanan->details()->sum('subtotal');

        $pemesanan->update([
            'subtotal' => $subtotal,
            'grand_total' => $subtotal,
        ]);
    }

    private function generateNomorPemesanan(): string
    {
        $tanggal = now()->format('Ymd');

        $last = Pemesanan::whereDate('created_at', today())->count() + 1;

        return 'PSN-' . $tanggal . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }
}
