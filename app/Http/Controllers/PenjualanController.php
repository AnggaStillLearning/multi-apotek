<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
        )
        ->select(
            'nama_obat'
        )
        ->distinct()
        ->orderBy('nama_obat')
        ->get();

        return view(
            'penjualans.create',
            compact('obats')
        );
    }

    public function getInfoObat($nama)
{
    $obats = Obat::where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->where(
            'nama_obat',
            $nama
        )
        ->orderBy(
            'tanggal_kadaluarsa'
        )
        ->get();

    if($obats->isEmpty())
    {
        return response()->json([
            'stok' => 0,
            'harga' => 0
        ]);
    }

    return response()->json([

        'stok' => $obats->sum('stok'),

        'harga' => $obats->first()->harga_jual

    ]);
}
    public function store(Request $request)
{
    $request->validate([

        'nama_obat' => 'required|array|min:1',

        'nama_obat.*' => 'required|string',

        'qty' => 'required|array|min:1',

        'qty.*' => 'required|integer|min:1',

    ]);

    DB::beginTransaction();

    try {

        $totalHarga = 0;

        $penjualanDetails = [];

        /*
        |--------------------------------------------------------------------------
        | Validasi stok seluruh obat
        |--------------------------------------------------------------------------
        */

        foreach($request->nama_obat as $index => $namaObat){

            $qty = $request->qty[$index];

            $stokTotal = Obat::where(
                    'apotek_id',
                    auth()->user()->apotek_id
                )
                ->where(
                    'nama_obat',
                    $namaObat
                )
                ->sum('stok');

            if($stokTotal < $qty){

                DB::rollBack();

                return back()->with(
                    'error',
                    'Stok '.$namaObat.' tidak mencukupi.'
                );

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Hitung Total Harga
        |--------------------------------------------------------------------------
        */

        foreach($request->nama_obat as $index => $namaObat){

            $qty = $request->qty[$index];

            $harga = Obat::where(
                    'apotek_id',
                    auth()->user()->apotek_id
                )
                ->where(
                    'nama_obat',
                    $namaObat
                )
                ->orderBy(
                    'tanggal_kadaluarsa'
                )
                ->first()
                ->harga_jual;

            $totalHarga += $harga * $qty;

        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Header Penjualan
        |--------------------------------------------------------------------------
        */

        $penjualan = Penjualan::create([

            'apotek_id' => auth()->user()->apotek_id,

            'user_id' => auth()->id(),

            'tanggal' => now(),

            'total_harga' => $totalHarga,

            'status' => 'selesai'

        ]);

        /*
        |--------------------------------------------------------------------------
        | FEFO DIMULAI DI SINI
        |--------------------------------------------------------------------------
        */
        foreach ($request->nama_obat as $index => $namaObat) {

    $qtyDiminta = $request->qty[$index];

    $batchObat = Obat::where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->where(
            'nama_obat',
            $namaObat
        )
        ->where(
            'stok',
            '>',
            0
        )
        ->orderBy(
            'tanggal_kadaluarsa',
            'asc'
        )
        ->get();

    foreach ($batchObat as $batch) {

        if ($qtyDiminta <= 0) {
            break;
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan jumlah yang diambil dari batch ini
        |--------------------------------------------------------------------------
        */

        $qtyAmbil = min(
            $qtyDiminta,
            $batch->stok
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan Detail Penjualan
        |--------------------------------------------------------------------------
        */

        PenjualanDetail::create([

            'penjualan_id' => $penjualan->id,

            'obat_id' => $batch->id,

            'qty' => $qtyAmbil,

            'harga' => $batch->harga_jual,

            'subtotal' => $qtyAmbil * $batch->harga_jual,

        ]);

        /*
        |--------------------------------------------------------------------------
        | Kurangi stok batch
        |--------------------------------------------------------------------------
        */

        $batch->decrement(
            'stok',
            $qtyAmbil
        );

        /*
        |--------------------------------------------------------------------------
        | Kurangi qty yang masih dibutuhkan
        |--------------------------------------------------------------------------
        */

        $qtyDiminta -= $qtyAmbil;

    }

}

        /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */

        DB::commit();

        return redirect()
            ->route('penjualans.index')
            ->with(
                'success',
                'Transaksi berhasil disimpan menggunakan metode FEFO.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->with(
                'error',
                $e->getMessage()
            );

    }
}

public function show(Penjualan $penjualan)
{
    if (
        $penjualan->apotek_id != auth()->user()->apotek_id
    ) {
        abort(403);
    }

    $penjualan->load([
        'details.obat'
    ]);

    return view(
        'penjualans.show',
        compact('penjualan')
    );
}
}
