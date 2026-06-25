<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\User;
use App\Models\Apotek;
use App\Models\Penjualan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // SUPER ADMIN
        if ($user->role === 'super_admin')
        {
            $totalApotek = Apotek::count();

            $totalAdmin = User::where(
                'role',
                'admin_apotek'
            )->count();

            $totalKasir = User::where(
                'role',
                'kasir'
            )->count();

            $totalObat = Obat::count();

            $totalTransaksi = Penjualan::count();

            $apoteks = Apotek::withCount('obats')->get();

            return view(
                'super-admin.dashboard',
                compact(
                    'totalApotek',
                    'totalAdmin',
                    'totalKasir',
                    'totalObat',
                    'totalTransaksi',
                    'apoteks'
                )
            );
        }

        // KASIR
        if ($user->role === 'kasir')
        {
            return view('kasir.dashboard');
        }

        // PEMBELI
        if ($user->role === 'pembeli')
        {
            return redirect('/');
        }

        // ADMIN APOTEK
        $apotekId = $user->apotek_id;

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
