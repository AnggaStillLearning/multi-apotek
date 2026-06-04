<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::where(
            'apotek_id',
            auth()->user()->apotek_id
        )->latest()->paginate(10);

        return view('obats.index', compact('obats'));
    }

    public function create()
    {
        return view('obats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'stok_minimum' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        Obat::create([
            'apotek_id' => auth()->user()->apotek_id,
            'nama_obat' => $request->nama_obat,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'stok_minimum' => $request->stok_minimum,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
        ]);

        return redirect()
            ->route('obats.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Obat $obat)
    {
        return view('obats.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'stok_minimum' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        $obat->update($request->all());

        return redirect()
            ->route('obats.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()
            ->route('obats.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
