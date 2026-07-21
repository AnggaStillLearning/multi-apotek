<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\User;
use App\Models\Apotek;
use App\Models\Penjualan;
use App\Models\BatchObat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // SUPER ADMIN
        if ($user->role === 'super_admin') {
            $totalApotek = Apotek::count();
            $totalAdmin = User::where('role', 'admin_apotek')->count();
            $totalKasir = User::where('role', 'kasir')->count();
            $totalObat = Obat::count();
            $totalTransaksi = Penjualan::count();
            $apoteks = Apotek::withCount('obats')->get();

            return view('super-admin.dashboard', compact(
                'totalApotek',
                'totalAdmin',
                'totalKasir',
                'totalObat',
                'totalTransaksi',
                'apoteks'
            ));
        }

        // KASIR
        if ($user->role === 'kasir') {
            return view('kasir.dashboard');
        }

        // PEMBELI
        if ($user->role === 'pembeli') {
            return redirect('/');
        }

        // ADMIN APOTEK
        $apotekId = $user->apotek_id;

        $totalObat = Obat::where('apotek_id', $apotekId)->count();

        $totalStok = Obat::where('apotek_id', $apotekId)
            ->sum('total_stok');

        $totalStokKritis = Obat::where('apotek_id', $apotekId)
            ->whereColumn('total_stok', '<=', 'stok_minimum')
            ->count();

        $totalKadaluarsa = BatchObat::whereHas('obat', function ($q) use ($apotekId) {
                $q->where('apotek_id', $apotekId);
            })
            ->whereBetween(
                'tanggal_kadaluarsa',
                [now(), now()->addDays(30)]
            )
            ->count();

        $stokKritis = Obat::where('apotek_id', $apotekId)
            ->whereColumn('total_stok', '<=', 'stok_minimum')
            ->orderBy('total_stok')
            ->take(5)
            ->get();

        $kadaluarsa = BatchObat::with('obat')
            ->whereHas('obat', function ($q) use ($apotekId) {
                $q->where('apotek_id', $apotekId);
            })
            ->whereBetween(
                'tanggal_kadaluarsa',
                [now(), now()->addDays(30)]
            )
            ->orderBy('tanggal_kadaluarsa')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalObat' => $totalObat,
            'totalStok' => $totalStok,
            'totalStokKritis' => $totalStokKritis,
            'totalKadaluarsa' => $totalKadaluarsa,
            'stokKritis' => $stokKritis,
            'kadaluarsa' => $kadaluarsa,
        ]);
    }
}
