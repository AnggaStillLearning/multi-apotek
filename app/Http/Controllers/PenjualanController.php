<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\BatchObat;
use App\Models\KonversiObat;

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

    public function create(Request $request)
{
    $query = Obat::with('konversis');

    $query->where(
        'apotek_id',
        auth()->user()->apotek_id
    );

    if ($request->filled('search')) {

        $query->where(
            'nama_obat',
            'like',
            '%' . $request->search . '%'
        );

    }

    $obats = $query
        ->orderBy('nama_obat')
        ->paginate(10)
        ->withQueryString();

    $cart = session()->get('cart', []);

    return view(
        'penjualans.create',
        compact(
            'obats',
            'cart'
        )
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
public function addToCart(Request $request)
{
    $request->validate([
        'obat_id' => 'required|exists:obats,id',
        'konversi_id' => 'required|exists:konversi_obats,id',
        'qty' => 'required|integer|min:1',
    ]);

    $obat = Obat::findOrFail($request->obat_id);

    $konversi = $obat->konversis()
        ->where('id', $request->konversi_id)
        ->firstOrFail();

    $cart = session()->get('cart', []);

    $cart[] = [

        'obat_id' => $obat->id,

        'nama_obat' => $obat->nama_obat,

        'konversi_id' => $konversi->id,

        'satuan' => $konversi->satuan->nama_satuan,

        'isi' => $konversi->isi,

        'harga_jual' => $konversi->harga_jual,

        'qty' => $request->qty,

        'subtotal' => $konversi->harga_jual * $request->qty,

    ];

    session()->put('cart', $cart);

    return redirect()
        ->route('penjualans.create')
        ->with('success', 'Obat berhasil ditambahkan ke keranjang.');
}
public function removeCart($index)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$index])) {

        unset($cart[$index]);

        session()->put(
            'cart',
            array_values($cart)
        );

    }

    return back();
}
public function updateCart(Request $request, $index)
{
    $request->validate([
        'qty' => 'required|integer|min:1',
    ]);

    $cart = session()->get('cart', []);

    if (!isset($cart[$index])) {
        return back()->with('error', 'Item tidak ditemukan.');
    }

    $cart[$index]['qty'] = $request->qty;

    $cart[$index]['subtotal'] =
        $cart[$index]['harga_jual'] * $request->qty;

    session()->put('cart', $cart);

    return back()->with('success', 'Jumlah berhasil diperbarui.');
}
public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Keranjang masih kosong.');
    }

    DB::beginTransaction();

    try {

        $grandTotal = collect($cart)->sum('subtotal');

        $penjualan = Penjualan::create([
            'apotek_id' => auth()->user()->apotek_id,
            'user_id' => auth()->id(),
            'tanggal_penjualan' => now(),
            'subtotal' => $grandTotal,
            'grand_total' => $grandTotal,
            'metode_pembayaran' => 'Tunai',
            'status' => 'Lunas',
        ]);

        DB::commit();

        return back()->with('success', 'Berhasil');

    } catch (\Throwable $e) {

        dd(
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );

    }
}
}
