<?php

namespace App\Http\Controllers;

use App\Models\Obat;

class DashboardController extends Controller
{
    public function index()
    {
        $apotekId = auth()->user()->apotek_id;

        $totalObat = Obat::where(
            'apotek_id',
            $apotekId
        )->count();

        $stokKritis = Obat::where(
            'apotek_id',
            $apotekId
        )
        ->whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        )
        ->get();

        $kadaluarsa = Obat::where(
            'apotek_id',
            $apotekId
        )
        ->whereDate(
            'tanggal_kadaluarsa',
            '<=',
            now()->addDays(30)
        )
        ->get();

        return view('dashboard', [
            'totalObat' => $totalObat,
            'totalStokKritis' => $stokKritis->count(),
            'totalKadaluarsa' => $kadaluarsa->count(),
            'stokKritis' => $stokKritis,
            'kadaluarsa' => $kadaluarsa,
        ]);
    }
}
