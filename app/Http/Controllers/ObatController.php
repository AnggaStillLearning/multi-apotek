<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\JenisObat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
{
    $query = Obat::with([
        'jenisObat',
        'kategori'
    ])
    ->where(
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

    if ($request->filled('jenis')) {

        $query->where(
            'jenis_obat_id',
            $request->jenis
        );

    }

    if ($request->filled('kategori')) {

        $query->where(
            'kategori_id',
            $request->kategori
        );

    }

    if ($request->stok == 'kritis') {

        $query->whereColumn(
            'stok',
            '<=',
            'stok_minimum'
        );

    }

    if ($request->expired == '1') {

        $query->whereDate(
            'tanggal_kadaluarsa',
            '<=',
            now()->addDays(30)
        );

    }

    $obats = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $jenisObats = JenisObat::all();

    $kategoris = Kategori::all();

    return view(
        'obats.index',
        compact(
            'obats',
            'jenisObats',
            'kategoris'
        )
    );
}

    public function create()
    {
        $jenisObats = JenisObat::all();

        $kategoris = Kategori::all();

        return view(
            'obats.create',
            compact(
                'jenisObats',
                'kategoris'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate(

[
    'jenis_obat_id' => 'required|exists:jenis_obats,id',

    'kategori_id' => 'required|exists:kategoris,id',

    'nama_obat' => 'required|string|max:255',

    'batch' => 'required|string|max:100',

    'harga_beli' => 'required|numeric|min:0',

    'harga_jual' => 'required|numeric|gte:harga_beli',

    'stok' => 'required|integer|min:0',

    'stok_minimum' => 'required|integer|min:0',

    'tanggal_kadaluarsa' => 'required|date',
],

[
    'jenis_obat_id.required' => 'Jenis obat harus dipilih.',
    'kategori_id.required' => 'Kategori obat harus dipilih.',
    'nama_obat.required' => 'Nama obat wajib diisi.',
    'batch.required' => 'Batch obat wajib diisi.',
    'harga_beli.required' => 'Harga beli wajib diisi.',
    'harga_jual.required' => 'Harga jual wajib diisi.',
    'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
    'stok.required' => 'Stok wajib diisi.',
    'stok_minimum.required' => 'Stok minimum wajib diisi.',
    'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
]

);


        Obat::create([

            'apotek_id' => auth()->user()->apotek_id,

            'jenis_obat_id' => $request->jenis_obat_id,

            'kategori_id' => $request->kategori_id,

            'nama_obat' => $request->nama_obat,

            'batch' => $request->batch,

            'harga_beli' => $request->harga_beli,

            'harga_jual' => $request->harga_jual,

            'stok' => $request->stok,

            'stok_minimum' => $request->stok_minimum,

            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,

        ]);

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Obat berhasil ditambahkan'
            );
    }

    public function edit(Obat $obat)
    {
        if (
            $obat->apotek_id != auth()->user()->apotek_id
        ) {
            abort(403);
        }

        $jenisObats = JenisObat::all();

        $kategoris = Kategori::all();

        return view(
            'obats.edit',
            compact(
                'obat',
                'jenisObats',
                'kategoris'
            )
        );
    }

    public function update(Request $request, Obat $obat)
    {
        if (
            $obat->apotek_id != auth()->user()->apotek_id
        ) {
            abort(403);
        }

        $request->validate(

[
    'jenis_obat_id' => 'required|exists:jenis_obats,id',

    'kategori_id' => 'required|exists:kategoris,id',

    'nama_obat' => 'required|string|max:255',

    'batch' => 'required|string|max:100',

    'harga_beli' => 'required|numeric|min:0',

    'harga_jual' => 'required|numeric|gte:harga_beli',

    'stok' => 'required|integer|min:0',

    'stok_minimum' => 'required|integer|min:0',

    'tanggal_kadaluarsa' => 'required|date',
],

[
    'jenis_obat_id.required' => 'Jenis obat harus dipilih.',
    'kategori_id.required' => 'Kategori obat harus dipilih.',
    'nama_obat.required' => 'Nama obat wajib diisi.',
    'batch.required' => 'Batch obat wajib diisi.',
    'harga_beli.required' => 'Harga beli wajib diisi.',
    'harga_jual.required' => 'Harga jual wajib diisi.',
    'harga_jual.gte' => 'Harga jual tidak boleh lebih kecil dari harga beli.',
    'stok.required' => 'Stok wajib diisi.',
    'stok_minimum.required' => 'Stok minimum wajib diisi.',
    'tanggal_kadaluarsa.required' => 'Tanggal kadaluarsa wajib diisi.',
]

);

        $obat->update([

            'jenis_obat_id' => $request->jenis_obat_id,

            'kategori_id' => $request->kategori_id,

            'nama_obat' => $request->nama_obat,

            'batch' => $request->batch,

            'harga_beli' => $request->harga_beli,

            'harga_jual' => $request->harga_jual,

            'stok' => $request->stok,

            'stok_minimum' => $request->stok_minimum,

            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,

        ]);

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Obat berhasil diperbarui'
            );
    }

    public function destroy(Obat $obat)
    {
        if (
            $obat->apotek_id != auth()->user()->apotek_id
        ) {
            abort(403);
        }

        $obat->delete();

        return redirect()
            ->route('obats.index')
            ->with(
                'success',
                'Obat berhasil dihapus'
            );
    }
}
