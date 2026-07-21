<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuanganRequest;
use App\Models\Gudang;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Menampilkan daftar ruangan
     */
    public function index(Request $request)
    {
        $query = Ruangan::with('gudang.apotek');

        // Admin hanya melihat ruangan milik apoteknya
        if (!auth()->user()->isSuperAdmin()) {

            $query->whereHas('gudang', function ($q) {

                $q->where(
                    'apotek_id',
                    auth()->user()->apotek_id
                );

            });

        }

        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'nama_ruangan',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'keterangan',
                    'like',
                    '%' . $request->search . '%'
                );

            });

        }

        $ruangans = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'ruangans.index',
            compact('ruangans')
        );
    }

    /**
     * Form tambah ruangan
     */
    public function create()
    {
        if (auth()->user()->isSuperAdmin()) {

            $gudangs = Gudang::orderBy('nama_gudang')->get();

        } else {

            $gudangs = Gudang::where(
                'apotek_id',
                auth()->user()->apotek_id
            )->orderBy('nama_gudang')->get();

        }

        return view(
            'ruangans.create',
            compact('gudangs')
        );
    }

    /**
     * Simpan ruangan
     */
    public function store(RuanganRequest $request)
    {
        $data = $request->validated();

        // Pastikan admin hanya bisa memilih gudang milik apoteknya
        if (!auth()->user()->isSuperAdmin()) {

            $gudang = Gudang::findOrFail($data['gudang_id']);

            if ($gudang->apotek_id != auth()->user()->apotek_id) {

                abort(403);

            }

        }

        Ruangan::create($data);

        return redirect()
            ->route('ruangans.index')
            ->with(
                'success',
                'Ruangan berhasil ditambahkan.'
            );
    }

    /**
     * Form edit
     */
    public function edit(Ruangan $ruangan)
    {
        $this->authorizeRuangan($ruangan);

        if (auth()->user()->isSuperAdmin()) {

            $gudangs = Gudang::orderBy('nama_gudang')->get();

        } else {

            $gudangs = Gudang::where(
                'apotek_id',
                auth()->user()->apotek_id
            )->orderBy('nama_gudang')->get();

        }

        return view(
            'ruangans.edit',
            compact(
                'ruangan',
                'gudangs'
            )
        );
    }

    /**
     * Update ruangan
     */
    public function update(
        RuanganRequest $request,
        Ruangan $ruangan
    ) {
        $this->authorizeRuangan($ruangan);

        $data = $request->validated();

        if (!auth()->user()->isSuperAdmin()) {

            $gudang = Gudang::findOrFail($data['gudang_id']);

            if ($gudang->apotek_id != auth()->user()->apotek_id) {

                abort(403);

            }

        }

        $ruangan->update($data);

        return redirect()
            ->route('ruangans.index')
            ->with(
                'success',
                'Ruangan berhasil diperbarui.'
            );
    }

    /**
     * Hapus ruangan
     */
    public function destroy(Ruangan $ruangan)
    {
        $this->authorizeRuangan($ruangan);

        $ruangan->delete();

        return redirect()
            ->route('ruangans.index')
            ->with(
                'success',
                'Ruangan berhasil dihapus.'
            );
    }

    /**
     * Authorization
     */
    private function authorizeRuangan(Ruangan $ruangan): void
    {
        if (
            !auth()->user()->isSuperAdmin()
            &&
            $ruangan->gudang->apotek_id != auth()->user()->apotek_id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke data ruangan ini.'
            );
        }
    }
}
