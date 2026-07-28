<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

/**
 * Dipakai oleh halaman kasir (Pembelian Offline, Fase 6) untuk cari obat
 * secara live-search. Dibatasi ke apotek milik kasir/admin yang login &
 * cuma obat dengan stok tersisa yang muncul.
 */
class ObatApiController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $obats = Obat::with(['konversis' => fn ($query) => $query->orderBy('urutan')])
            ->with('konversis.satuan')
            ->where('apotek_id', auth()->user()->apotek_id)
            ->where('total_stok', '>', 0)
            ->where('nama_obat', 'like', '%' . $q . '%')
            ->orderBy('nama_obat')
            ->limit(10)
            ->get()
            ->map(fn ($obat) => [
                'id' => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'stok_text' => $obat->breakdownStokText(),
                'konversis' => $obat->konversis->map(fn ($k) => [
                    'id' => $k->id,
                    'nama_satuan' => $k->satuan->nama_satuan,
                    'harga_jual' => $k->harga_jual,
                    'is_default' => $k->is_default,
                ]),
            ]);

        return response()->json($obats);
    }
}
