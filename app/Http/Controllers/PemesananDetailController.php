<?php

namespace App\Http\Controllers;

use App\Models\PemesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Ubah/hapus 1 baris item di keranjang (Pemesanan). Dipisah dari
 * PemesananController mengikuti pola PengadaanDetailController di Fase 4:
 * siklus hidup item beda dari header keranjangnya.
 */
class PemesananDetailController extends Controller
{
    public function update(Request $request, PemesananDetail $detail)
    {
        $pemesanan = $detail->pemesanan;

        $this->authorizeOwner($pemesanan);

        if ($pemesanan->status !== 'draft') {
            return back()->with(
                'error',
                'Item tidak dapat diubah karena keranjang sudah tidak berstatus draft.'
            );
        }

        $validated = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $obat = $detail->obat;

        if (!$obat->cukupStok($detail->konversi_obat_id, $validated['qty'])) {
            return back()->with(
                'error',
                'Jumlah melebihi stok yang tersedia.'
            );
        }

        DB::transaction(function () use ($detail, $validated, $pemesanan) {

            $detail->update([
                'qty' => $validated['qty'],
                'subtotal' => $validated['qty'] * $detail->harga_jual,
            ]);

            PemesananController::recalculateTotal($pemesanan);
        });

        return back()->with(
            'success',
            'Jumlah berhasil diperbarui.'
        );
    }

    public function destroy(PemesananDetail $detail)
    {
        $pemesanan = $detail->pemesanan;

        $this->authorizeOwner($pemesanan);

        if ($pemesanan->status !== 'draft') {
            return back()->with(
                'error',
                'Item tidak dapat dihapus karena keranjang sudah tidak berstatus draft.'
            );
        }

        $keranjangKosong = DB::transaction(function () use ($detail, $pemesanan) {

            $detail->delete();

            // Keranjang kosong tidak perlu dipertahankan sebagai baris draft.
            if ($pemesanan->details()->count() === 0) {
                $pemesanan->delete();
                return true;
            }

            PemesananController::recalculateTotal($pemesanan);

            return false;
        });

        if ($keranjangKosong) {
            return redirect()
                ->route('pemesanan.index')
                ->with('success', 'Obat berhasil dihapus dari keranjang.');
        }

        return back()->with(
            'success',
            'Obat berhasil dihapus dari keranjang.'
        );
    }

    private function authorizeOwner($pemesanan): void
    {
        if ($pemesanan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses ke keranjang ini.');
        }
    }
}
