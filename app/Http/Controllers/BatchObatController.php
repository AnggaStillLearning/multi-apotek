<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchObatRequest;
use App\Models\BatchObat;
use App\Models\Gudang;
use App\Models\Obat;
use App\Models\Ruangan;

class BatchObatController extends Controller
{
    /**
     * Store a newly created batch.
     */
    public function store(Obat $obat, BatchObatRequest $request)
{
    $this->authorizeObat($obat);

    $data = $request->validated();

    // Validasi Gudang
    $gudang = Gudang::findOrFail($data['gudang_id']);

    if (
        !auth()->user()->isSuperAdmin()
        && $gudang->apotek_id != auth()->user()->apotek_id
    ) {
        abort(403);
    }

    // Validasi Ruangan
    $ruangan = Ruangan::findOrFail($data['ruangan_id']);

    if ($ruangan->gudang_id != $gudang->id) {

        return back()
            ->withErrors([
                'ruangan_id' => 'Ruangan tidak berada pada gudang yang dipilih.'
            ])
            ->withInput();
    }

    // Simpan Batch
    $obat->batchObats()->create([

        'gudang_id' => $data['gudang_id'],

        'ruangan_id' => $data['ruangan_id'],

        'nomor_batch' => $data['nomor_batch'],

        'stok' => $data['stok'],

        'harga_beli' => $data['harga_beli'],

        'tanggal_kadaluarsa' => $data['tanggal_kadaluarsa'],

    ]);

    // Update Total Stok
    $obat->update([
        'total_stok' => $obat->batchObats()->sum('stok')
    ]);

    return redirect()
        ->route('obats.show', $obat)
        ->with('success', 'Batch berhasil ditambahkan.');
}

public function edit(BatchObat $batch)
{
    $this->authorizeObat($batch->obat);

    return response()->json([

        'id' => $batch->id,

        'nomor_batch' => $batch->nomor_batch,

        'gudang_id' => $batch->gudang_id,

        'ruangan_id' => $batch->ruangan_id,

        'harga_beli' => $batch->harga_beli,

        'stok' => $batch->stok,

        'tanggal_kadaluarsa' => $batch->tanggal_kadaluarsa,

    ]);
}
    /**
     * Update the specified batch.
     */
    public function update(
    BatchObatRequest $request,
    BatchObat $batch
) {

    $this->authorizeObat($batch->obat);

    $data = $request->validated();

    $gudang = Gudang::findOrFail($data['gudang_id']);

    if (
        !auth()->user()->isSuperAdmin()
        && $gudang->apotek_id != auth()->user()->apotek_id
    ) {
        abort(403);
    }

    $ruangan = Ruangan::findOrFail($data['ruangan_id']);

    if ($ruangan->gudang_id != $gudang->id) {

        return back()
            ->withErrors([
                'ruangan_id' =>
                    'Ruangan tidak berada pada gudang yang dipilih.'
            ])
            ->withInput();

    }

    $batch->update([

        'gudang_id' => $data['gudang_id'],

        'ruangan_id' => $data['ruangan_id'],

        'stok' => $data['stok'],

        'harga_beli' => $data['harga_beli'],

        'tanggal_kadaluarsa' => $data['tanggal_kadaluarsa'],

    ]);

    $batch->obat->update([

        'total_stok' =>
            $batch->obat
                ->batchObats()
                ->sum('stok')

    ]);

    return redirect()
        ->route('obats.show', $batch->obat)
        ->with(
            'success',
            'Batch berhasil diperbarui.'
        );

}

    /**
     * Remove the specified batch.
     */
    public function destroy(BatchObat $batch)
{
    $this->authorizeBatch($batch);

    $obat = $batch->obat;

    $batch->delete();

    $obat->update([
        'total_stok' => $obat->batchObats()->sum('stok')
    ]);

    return redirect()
        ->route('obats.show', $obat)
        ->with('success', 'Batch berhasil dihapus.');
}
    public function getRuangan(Gudang $gudang)
{
    return response()->json(
        $gudang->ruangans()
            ->orderBy('nama_ruangan')
            ->get([
                'id',
                'nama_ruangan'
            ])
    );
}

    /**
     * Authorize user to access the obat.
     */
    private function authorizeObat(Obat $obat)
    {
        if (!auth()->user()->isSuperAdmin() && $obat->apotek_id != auth()->user()->apotek_id) {
            abort(403);
        }
    }

    /**
     * Authorize user to access the batch.
     */
    private function authorizeBatch(BatchObat $batch)
    {
        if (!auth()->user()->isSuperAdmin() && $batch->obat->apotek_id != auth()->user()->apotek_id) {
            abort(403);
        }
    }
}
