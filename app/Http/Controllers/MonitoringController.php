<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\BatchObat;
use Illuminate\Support\Collection;

class MonitoringController extends Controller
{
    public function stokKritis()
{
    $apotekId = auth()->user()->apotek_id;

    $obats = Obat::where('apotek_id', $apotekId)
        ->whereColumn('total_stok', '<=', 'stok_minimum')
        ->orderBy('total_stok')
        ->paginate(10);

    return view(
        'monitoring.stok-kritis',
        compact('obats')
    );
}

    public function kadaluarsa()
{
    $apotekId = auth()->user()->apotek_id;

    $obats = BatchObat::with([
            'obat',
            'gudang',
            'ruangan'
        ])
        ->whereHas('obat', function ($q) use ($apotekId) {
            $q->where('apotek_id', $apotekId);
        })
        ->whereBetween(
            'tanggal_kadaluarsa',
            [
                now(),
                now()->addDays(30)
            ]
        )
        ->orderBy('tanggal_kadaluarsa')
        ->paginate(10);

    return view(
        'monitoring.kadaluarsa',
        compact('obats')
    );
}
}
