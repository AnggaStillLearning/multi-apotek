<?php

namespace App\Http\Controllers;

use App\Models\BatchObat;
use App\Models\Obat;
use Illuminate\Http\Request;

/**
 * Monitoring digabung jadi 1 halaman dengan 3 tab (Fase 7), gantikan
 * stokKritis() & kadaluarsa() yang tadinya 2 halaman/route terpisah.
 * Tab aktif ditentukan lewat query string ?tab=..., bukan JS toggle,
 * supaya tiap tab tetap punya pagination-nya sendiri lewat URL biasa
 * (konsisten dengan pola paginate()->withQueryString() yang sudah dipakai
 * di modul lain).
 */
class MonitoringController extends Controller
{
    private const TABS = ['stok-kritis', 'akan-kadaluarsa', 'kadaluarsa'];

    public function index(Request $request)
    {
        $apotekId = auth()->user()->apotek_id;

        $tab = $request->get('tab', 'stok-kritis');

        if (!in_array($tab, self::TABS)) {
            $tab = 'stok-kritis';
        }

        $obats = null;
        $batches = null;

        if ($tab === 'stok-kritis') {

            $obats = Obat::where('apotek_id', $apotekId)
                ->whereColumn('total_stok', '<=', 'stok_minimum')
                ->orderBy('total_stok')
                ->paginate(10)
                ->withQueryString();

        } elseif ($tab === 'akan-kadaluarsa') {

            // Batch dengan stok tersisa yang kadaluarsa dalam 30 hari ke depan.
            $batches = BatchObat::with(['obat', 'gudang', 'ruangan'])
                ->whereHas('obat', fn ($q) => $q->where('apotek_id', $apotekId))
                ->where('stok', '>', 0)
                ->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)])
                ->orderBy('tanggal_kadaluarsa')
                ->paginate(10)
                ->withQueryString();

        } else {

            // Batch dengan stok tersisa yang sudah lewat tanggal kadaluarsa
            // — belum pernah ditampilkan sama sekali sebelum Fase 7 (versi
            // lama cuma menampilkan yang AKAN kadaluarsa dalam 30 hari,
            // yang SUDAH kadaluarsa tidak pernah kelihatan di mana pun).
            $batches = BatchObat::with(['obat', 'gudang', 'ruangan'])
                ->whereHas('obat', fn ($q) => $q->where('apotek_id', $apotekId))
                ->where('stok', '>', 0)
                ->where('tanggal_kadaluarsa', '<', now())
                ->orderBy('tanggal_kadaluarsa')
                ->paginate(10)
                ->withQueryString();

        }

        // Badge angka di label tab — hitungan ringan (count saja, tidak paginate).
        $jumlah = [
            'stok-kritis' => Obat::where('apotek_id', $apotekId)
                ->whereColumn('total_stok', '<=', 'stok_minimum')
                ->count(),

            'akan-kadaluarsa' => BatchObat::whereHas('obat', fn ($q) => $q->where('apotek_id', $apotekId))
                ->where('stok', '>', 0)
                ->whereBetween('tanggal_kadaluarsa', [now(), now()->addDays(30)])
                ->count(),

            'kadaluarsa' => BatchObat::whereHas('obat', fn ($q) => $q->where('apotek_id', $apotekId))
                ->where('stok', '>', 0)
                ->where('tanggal_kadaluarsa', '<', now())
                ->count(),
        ];

        return view(
            'monitoring.index',
            compact('tab', 'obats', 'batches', 'jumlah')
        );
    }
}
