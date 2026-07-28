<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use App\Models\Obat;

/**
 * Menangani sisi "etalase" toko online: daftar apotek, katalog obat per
 * apotek, dan detail satu obat. Operasi keranjang/checkout sudah dipindah
 * ke PemesananController & PembelianOnlineController (Fase 5) supaya
 * keranjang tersimpan di database (Pemesanan), bukan session lagi.
 *
 * Bug yang diperbaiki di sini (dicatat dari rencana revisi §0):
 * - $obat->stok & $obat->harga_jual tidak pernah ada di kolom `obats`
 *   (kolom sebenarnya `total_stok`, harga ada di `konversi_obats.harga_jual`
 *   per satuan). Sekarang pakai total_stok + konversi default.
 * - $obat->kategori->nama_kategori & $obat->jenisObat salah nama kolom/relasi
 *   (seharusnya `nama` dan relasi `jenis()`).
 * - shop.show tidak pernah memfilter obat berdasarkan apotek yang sedang
 *   dijelajahi, jadi produk apotek lain bisa "bocor" kalau ID ditebak.
 */
class ShopController extends Controller
{
    public function apoteks()
    {
        $apoteks = Apotek::orderBy('nama_apotek')->get();

        return view('shop.apoteks', compact('apoteks'));
    }

    public function katalog(Apotek $apotek)
    {
        $obats = Obat::with([
                'kategori',
                'jenis',
                'konversis.satuan',
            ])
            ->where('apotek_id', $apotek->id)
            ->where('total_stok', '>', 0)
            ->orderBy('nama_obat')
            ->paginate(12)
            ->withQueryString();

        return view(
            'shop.katalog',
            compact('apotek', 'obats')
        );
    }

    public function show(Apotek $apotek, Obat $obat)
    {
        if ($obat->apotek_id !== $apotek->id) {
            abort(404);
        }

        $obat->load(['kategori', 'jenis', 'konversis.satuan']);

        return view(
            'shop.show',
            compact('apotek', 'obat')
        );
    }
}
