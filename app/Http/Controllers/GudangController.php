<?php

namespace App\Http\Controllers;

use App\Http\Requests\GudangRequest;
use App\Models\Apotek;
use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Tampilkan daftar gudang
     */
    public function index(Request $request)
    {
        $query = Gudang::with('apotek');

        // Admin hanya melihat gudang milik apoteknya
        if (!auth()->user()->isSuperAdmin()) {
            $query->where(
                'apotek_id',
                auth()->user()->apotek_id
            );
        }

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'nama_gudang',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'alamat',
                    'like',
                    '%' . $request->search . '%'
                );

            });

        }

        $gudangs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'gudangs.index',
            compact('gudangs')
        );
    }

    /**
     * Detail gudang beserta daftar ruangannya
     */
    public function show(Gudang $gudang)
    {
        $this->authorizeGudang($gudang);

        $gudang->load('apotek', 'ruangans');

        return view(
            'gudangs.show',
            compact('gudang')
        );
    }

    /**
     * Form tambah gudang
     */
    public function create()
    {
        $apoteks = Apotek::all();

        return view(
            'gudangs.create',
            compact('apoteks')
        );
    }

    /**
     * Simpan gudang
     */
    public function store(GudangRequest $request)
    {
        $data = $request->validated();

        // Admin apotek otomatis memakai apotek miliknya
        if (!auth()->user()->isSuperAdmin()) {
            $data['apotek_id'] = auth()->user()->apotek_id;
        }

        Gudang::create($data);

        return redirect()
            ->route('gudangs.index')
            ->with(
                'success',
                'Gudang berhasil ditambahkan.'
            );
    }

    /**
     * Form edit
     */
    public function edit(Gudang $gudang)
    {
        $this->authorizeGudang($gudang);

        $apoteks = Apotek::all();

        return view(
            'gudangs.edit',
            compact(
                'gudang',
                'apoteks'
            )
        );
    }

    /**
     * Update gudang
     */
    public function update(
        GudangRequest $request,
        Gudang $gudang
    ) {
        $this->authorizeGudang($gudang);

        $data = $request->validated();

        if (!auth()->user()->isSuperAdmin()) {
            $data['apotek_id'] = auth()->user()->apotek_id;
        }

        $gudang->update($data);

        return redirect()
            ->route('gudangs.index')
            ->with(
                'success',
                'Gudang berhasil diperbarui.'
            );
    }

    /**
     * Hapus gudang
     */
    public function destroy(Gudang $gudang)
    {
        $this->authorizeGudang($gudang);

        $gudang->delete();

        return redirect()
            ->route('gudangs.index')
            ->with(
                'success',
                'Gudang berhasil dihapus.'
            );
    }

    /**
     * Authorization
     */
    private function authorizeGudang(Gudang $gudang): void
    {
        if (
            !auth()->user()->isSuperAdmin()
            &&
            $gudang->apotek_id !== auth()->user()->apotek_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke data gudang ini.');
        }
    }
}
