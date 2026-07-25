<?php

namespace App\Http\Controllers;

use App\Models\Pengadaan;
use App\Models\PengadaanDetail;
use App\Models\KonversiObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengadaanDetailController extends Controller
{
    /**
     * Tambah item pengadaan.
     */
    public function store(Request $request, Pengadaan $pengadaan)
    {
        if ($pengadaan->status !== 'draft') {
            return back()->with(
                'error',
                'Item tidak dapat ditambahkan karena pengadaan sudah tidak berstatus draft.'
            );
        }

        $validated = $request->validate([
            'obat_id'             => 'required|exists:obats,id',
            'konversi_obat_id'    => 'required|exists:konversi_obats,id',
            'gudang_id'           => 'required|exists:gudangs,id',
            'ruangan_id'          => 'required|exists:ruangans,id',
            'nomor_batch'         => 'required|string|max:100',
            'tanggal_kadaluarsa'  => 'nullable|date',
            'qty'                 => 'required|integer|min:1',
            'harga_beli'          => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $pengadaan) {

            $konversi = KonversiObat::findOrFail($validated['konversi_obat_id']);

            PengadaanDetail::create([

                'pengadaan_id' => $pengadaan->id,

                'obat_id' => $validated['obat_id'],

                'konversi_obat_id' => $validated['konversi_obat_id'],

                'gudang_id' => $validated['gudang_id'],

                'ruangan_id' => $validated['ruangan_id'],

                'nomor_batch' => $validated['nomor_batch'],

                'tanggal_kadaluarsa' => $validated['tanggal_kadaluarsa'],

                'qty' => $validated['qty'],

                // sementara menggunakan isi
                'qty_dasar' => $validated['qty'] * $konversi->isi,

                'harga_beli' => $validated['harga_beli'],

                'subtotal' => $validated['qty'] * $validated['harga_beli'],
            ]);

            $pengadaan->update([
                'subtotal' => $pengadaan->details()->sum('subtotal'),
                'grand_total' => $pengadaan->details()->sum('subtotal'),
            ]);
        });

        return back()->with(
            'success',
            'Item berhasil ditambahkan.'
        );
    }

    /**
     * Update item pengadaan.
     */
    public function update(Request $request, PengadaanDetail $detail)
    {
        if ($detail->pengadaan->status !== 'draft') {
            return back()->with(
                'error',
                'Item tidak dapat diubah karena pengadaan sudah tidak berstatus draft.'
            );
        }

        $validated = $request->validate([

            'qty' => 'required|integer|min:1',

            'harga_beli' => 'required|numeric|min:0',

            'gudang_id' => 'required|exists:gudangs,id',

            'ruangan_id' => 'required|exists:ruangans,id',

            'tanggal_kadaluarsa' => 'nullable|date',

        ]);

        DB::transaction(function () use ($validated, $detail) {

            $konversi = $detail->konversi;

            $detail->update([

                'qty' => $validated['qty'],

                'qty_dasar' => $validated['qty'] * $konversi->isi,

                'harga_beli' => $validated['harga_beli'],

                'subtotal' => $validated['qty'] * $validated['harga_beli'],

                'gudang_id' => $validated['gudang_id'],

                'ruangan_id' => $validated['ruangan_id'],

                'tanggal_kadaluarsa' => $validated['tanggal_kadaluarsa'],

            ]);

            $pengadaan = $detail->pengadaan;

            $pengadaan->update([

                'subtotal' => $pengadaan->details()->sum('subtotal'),

                'grand_total' => $pengadaan->details()->sum('subtotal'),

            ]);
        });

        return back()->with(
            'success',
            'Item berhasil diperbarui.'
        );
    }

    /**
     * Hapus item pengadaan.
     */
    public function destroy(PengadaanDetail $detail)
    {
        if ($detail->pengadaan->status !== 'draft') {
            return back()->with(
                'error',
                'Item tidak dapat dihapus karena pengadaan sudah tidak berstatus draft.'
            );
        }

        DB::transaction(function () use ($detail) {

            $pengadaan = $detail->pengadaan;

            $detail->delete();

            $pengadaan->update([

                'subtotal' => $pengadaan->details()->sum('subtotal'),

                'grand_total' => $pengadaan->details()->sum('subtotal'),

            ]);
        });

        return back()->with(
            'success',
            'Item berhasil dihapus.'
        );
    }
}
