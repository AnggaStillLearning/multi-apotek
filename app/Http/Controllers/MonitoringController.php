<?php

namespace App\Http\Controllers;

use App\Models\Obat;

class MonitoringController extends Controller
{
    public function stokKritis()
    {
        $obats = Obat::where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )
        ->get();

        return view(
            'monitoring.stok-kritis',
            compact('obats')
        );
    }
}
