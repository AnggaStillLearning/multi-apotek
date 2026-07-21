<?php

namespace App\Http\Controllers;

use App\Http\Requests\ObatRequest;
use App\Models\Obat;
use App\Models\JenisObat;
use App\Models\Kategori;
use App\Models\Gudang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Menampilkan daftar obat
     */
    public function index(Request $request)
    {
        $query = Obat::with([
            'jenis',
            'kategori',
            'batchObats',
            'konversis'
        ]);

        // Admin hanya melihat obat milik apoteknya
        if (!auth()->user()->isSuperAdmin()) {

            $query->where(
                'apotek_id',
                auth()->user()->apotek_id
            );

        }

        // Search
        if ($request->filled('search')) {

            $query->where(
                'nama_obat',
                'like',
                '%' . $request->search . '%'
            );

        }

        // Filter Jenis
        if ($request->filled('jenis')) {

            $query->where(
                'jenis_obat_id',
                $request->jenis
            );

        }

        // Filter Kategori
        if ($request->filled('kategori')) {

            $query->where(
                'kategori_id',
                $request->kategori
            );

        }

        $obats = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $jenisObats = JenisObat::orderBy('nama')->get();

        $kategoris = Kategori::orderBy('nama')->get();

        return view(
            'obats.index',
            compact(
                'obats',
                'jenisObats',
                'kategoris'
            )
        );
    }

    /**
     * Form tambah obat
     */
    public function create()
    {
        $jenisObats = JenisObat::orderBy('nama')->get();

        $kategoris = Kategori::orderBy('nama')->get();

        return view(
            'obats.create',
            compact(
                'jenisObats',
                'kategoris'
            )
        );
    }

    /**
     * Simpan obat
     */
    public function store(ObatRequest $request)
    {
        $data = $request->validated();

        // Admin otomatis memakai apotek miliknya
        if (!auth()->user()->isSuperAdmin()) {

            $data['apotek_id'] = auth()->user()->apotek_id;

        }

        Obat::create($data);

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Obat berhasil ditambahkan.'
            );
    }
        /**
     * Detail obat
     */
   public function show(Obat $obat)
{
    $this->authorizeObat($obat);

    $obat->load([
        'kategori',
        'jenis',
        'konversis.satuan',
        'batchObats.gudang',
        'batchObats.ruangan'
    ]);

    if (auth()->user()->isSuperAdmin()) {

        $gudangs = Gudang::orderBy('nama_gudang')->get();

    } else {

        $gudangs = Gudang::where(
            'apotek_id',
            auth()->user()->apotek_id
        )
        ->orderBy('nama_gudang')
        ->get();

    }

    // Tambahkan ini
    $satuans = Satuan::orderBy('nama_satuan')->get();

    return view(
        'obats.show',
        compact(
            'obat',
            'gudangs',
            'satuans'
        )
    );
}

    /**
     * Form edit obat
     */
    public function edit(Obat $obat)
    {
        $this->authorizeObat($obat);

        $jenisObats = JenisObat::orderBy('nama')->get();

        $kategoris = Kategori::orderBy('nama')->get();

        return view(
            'obats.edit',
            compact(
                'obat',
                'jenisObats',
                'kategoris'
            )
        );
    }

    /**
     * Update obat
     */
    public function update(
        ObatRequest $request,
        Obat $obat
    ) {
        $this->authorizeObat($obat);

        $data = $request->validated();

        if (!auth()->user()->isSuperAdmin()) {

            $data['apotek_id'] = auth()->user()->apotek_id;

        }

        $obat->update($data);

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Data obat berhasil diperbarui.'
            );
    }

    /**
     * Hapus obat
     */
    public function destroy(Obat $obat)
    {
        $this->authorizeObat($obat);

        // Tidak boleh dihapus jika sudah memiliki batch
        if ($obat->batchObats()->exists()) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Obat tidak dapat dihapus karena masih memiliki data batch.'
                );

        }

        $obat->delete();

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Obat berhasil dihapus.'
            );
    }

    /**
     * Authorization
     */
    private function authorizeObat(Obat $obat): void
    {
        if (
            !auth()->user()->isSuperAdmin()
            &&
            $obat->apotek_id != auth()->user()->apotek_id
        ) {

            abort(
                403,
                'Anda tidak memiliki akses ke data obat ini.'
            );

        }
    }
}
