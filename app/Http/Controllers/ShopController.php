<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Apotek;

class ShopController extends Controller
{
    public function index()
    {
        $obats = Obat::with([
                'kategori',
                'jenisObat'
            ])
            ->where('stok', '>', 0)
            ->orderBy('nama_obat')
            ->paginate(12);

        return view(
            'shop.index',
            compact('obats')
        );
    }

    public function show(Obat $obat)
    {
        return view(
            'shop.show',
            compact('obat')
        );
    }
    public function cart()
{
    $cart = session()->get('cart', []);

    return view(
        'shop.cart',
        compact('cart')
    );
}
public function apoteks()
{
    $apoteks = Apotek::orderBy('nama_apotek')->get();

    return view('shop.apoteks', compact('apoteks'));
}

public function katalog(Apotek $apotek)
{
    $obats = Obat::with([
            'kategori',
            'jenis'
        ])
        ->where('apotek_id', $apotek->id)
        ->where('total_stok', '>', 0)
        ->orderBy('nama_obat')
        ->paginate(12);

    return view(
        'shop.katalog',
        compact(
            'apotek',
            'obats'
        )
    );
}

public function addToCart(Obat $obat)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$obat->id])) {

        if ($cart[$obat->id]['qty'] >= $obat->stok) {

            return back()->with(
                'error',
                'Jumlah melebihi stok yang tersedia.'
            );

        }

        $cart[$obat->id]['qty']++;

    } else {

        $cart[$obat->id] = [

            'id' => $obat->id,

            'nama' => $obat->nama_obat,

            'harga' => $obat->harga_jual,

            'qty' => 1,

            'stok' => $obat->stok,

        ];

    }

    session()->put('cart', $cart);

    return back()->with(
        'success',
        'Obat berhasil ditambahkan ke keranjang.'
    );
}

public function updateCart(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {

        $qty = (int) $request->qty;

        if ($qty < 1) {
            $qty = 1;
        }

        if ($qty > $cart[$id]['stok']) {
            $qty = $cart[$id]['stok'];
        }

        $cart[$id]['qty'] = $qty;

        session()->put('cart', $cart);
    }

    return back()->with(
        'success',
        'Jumlah berhasil diperbarui.'
    );
}

public function removeCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {

        unset($cart[$id]);

        session()->put('cart', $cart);

    }

    return back()->with(
        'success',
        'Obat berhasil dihapus dari keranjang.'
    );
}
public function checkout()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {

        return redirect()
            ->route('cart.index')
            ->with(
                'error',
                'Keranjang masih kosong.'
            );

    }

    $total = 0;

    foreach ($cart as $item) {

        $total += $item['harga'] * $item['qty'];

    }

    $apoteks = Apotek::orderBy('nama_apotek')->get();

    return view(
        'shop.checkout',
        compact(
            'cart',
            'total',
            'apoteks'
        )
    );
}

public function storeCheckout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {

        return redirect()
            ->route('cart.index')
            ->with(
                'error',
                'Keranjang kosong.'
            );

    }

    DB::beginTransaction();

    try {

        $total = 0;

        foreach ($cart as $item) {

            $total += $item['harga'] * $item['qty'];

        }

        $penjualan = Penjualan::create([

        'apotek_id' => $request->apotek_id,

        'user_id' => auth()->id(),

        'tanggal' => now(),

        'total_harga' => $total,

        'status' => 'menunggu_pembayaran',

        // 'catatan' => $request->catatan,

    ]);

        foreach ($cart as $item) {

            PenjualanDetail::create([

                'penjualan_id' => $penjualan->id,

                'obat_id' => $item['id'],

                'qty' => $item['qty'],

                'harga' => $item['harga'],

                'subtotal' => $item['qty'] * $item['harga'],

            ]);

        }

        DB::commit();

        session()->forget('cart');

        return redirect()
            ->route(
                'shop.order.show',
                $penjualan
            )
            ->with(
                'success',
                'Pesanan berhasil dibuat.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with(
            'error',
            $e->getMessage()
        );

    }
}
}
