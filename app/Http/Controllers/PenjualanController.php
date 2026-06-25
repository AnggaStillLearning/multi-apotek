<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->latest()
        ->get();

        return view(
            'penjualans.index',
            compact('penjualans')
        );
    }

    public function create()
    {
        $obats = Obat::where(
            'apotek_id',
            auth()->user()->apotek_id
        )->get();

        return view(
            'penjualans.create',
            compact('obats')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required',
            'qty' => 'required|integer|min:1'
        ]);

        // Pastikan obat milik apotek yang sedang login
        $obat = Obat::where(
            'id',
            $request->obat_id
        )
        ->where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->firstOrFail();

        if($request->qty > $obat->stok)
        {
            return back()
                ->with(
                    'error',
                    'Stok tidak mencukupi'
                );
        }

        $total = $obat->harga_jual * $request->qty;

        $penjualan = Penjualan::create([
            'apotek_id' => auth()->user()->apotek_id,
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total_harga' => $total
        ]);

        PenjualanDetail::create([
            'penjualan_id' => $penjualan->id,
            'obat_id' => $obat->id,
            'qty' => $request->qty,
            'harga' => $obat->harga_jual,
            'subtotal' => $total
        ]);

        $obat->decrement(
            'stok',
            $request->qty
        );

        return redirect()
            ->route('penjualans.index')
            ->with(
                'success',
                'Transaksi berhasil'
            );
    }

    public function show(Penjualan $penjualan)
    {
        // Pastikan transaksi milik apotek yang login
        if(
            $penjualan->apotek_id != auth()->user()->apotek_id
        )
        {
            abort(403);
        }

        $penjualan->load(
            'details.obat'
        );

        return view(
            'penjualans.show',
            compact('penjualan')
        );
    }
}
