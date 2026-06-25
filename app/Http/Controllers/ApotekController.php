<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use Illuminate\Http\Request;

class ApotekController extends Controller
{
    public function index()
    {
        $apoteks = Apotek::latest()->get();

        return view(
            'apoteks.index',
            compact('apoteks')
        );
    }

    public function create()
    {
        return view('apoteks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_apotek' => 'required',
            'alamat' => 'required'
        ]);

        Apotek::create($request->all());

        return redirect()
            ->route('apoteks.index')
            ->with(
                'success',
                'Apotek berhasil ditambahkan'
            );
    }

    public function edit(Apotek $apotek)
    {
        return view(
            'apoteks.edit',
            compact('apotek')
        );
    }

    public function update(
        Request $request,
        Apotek $apotek
    )
    {
        $request->validate([
            'nama_apotek' => 'required',
            'alamat' => 'required'
        ]);

        $apotek->update($request->all());

        return redirect()
            ->route('apoteks.index')
            ->with(
                'success',
                'Apotek berhasil diperbarui'
            );
    }

    public function destroy(Apotek $apotek)
    {
        $apotek->delete();

        return back()->with(
            'success',
            'Apotek berhasil dihapus'
        );
    }
}
