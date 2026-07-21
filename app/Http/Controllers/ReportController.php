<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::with([
            'user',
            'apotek'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Filter Role
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role == 'admin_apotek') {

            $query->where(
                'apotek_id',
                auth()->user()->apotek_id
            );

        } elseif (auth()->user()->role == 'kasir') {

            $query->where(
                'user_id',
                auth()->id()
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Periode Cepat
        |--------------------------------------------------------------------------
        */

        if ($request->filled('periode')) {

            switch ($request->periode) {

                case 'hari_ini':

                    $query->whereDate(
                        'tanggal',
                        today()
                    );

                    break;

                case 'minggu_ini':

                    $query->whereBetween(
                        'tanggal',
                        [
                            now()->startOfWeek(),
                            now()->endOfWeek()
                        ]
                    );

                    break;

                case 'bulan_ini':

                    $query->whereMonth(
                        'tanggal',
                        now()->month
                    )->whereYear(
                        'tanggal',
                        now()->year
                    );

                    break;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal Manual
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal_awal')) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_awal
            );

        }

        if ($request->filled('tanggal_akhir')) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_akhir
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $totalTransaksi = (clone $query)->count();

        $totalPendapatan = (clone $query)->sum(
            'total_harga'
        );

        $totalDibatalkan = (clone $query)
            ->where(
                'status',
                'dibatalkan'
            )
            ->count();

        $totalObatTerjual = (clone $query)
            ->join(
                'penjualan_details',
                'penjualans.id',
                '=',
                'penjualan_details.penjualan_id'
            )
            ->sum(
                'penjualan_details.qty'
            );

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $laporans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'laporan.index',
            compact(
                'laporans',
                'totalTransaksi',
                'totalPendapatan',
                'totalObatTerjual',
                'totalDibatalkan'
            )
        );
    }
}
