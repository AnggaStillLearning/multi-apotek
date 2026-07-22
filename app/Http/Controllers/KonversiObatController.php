<?php

namespace App\Http\Controllers;

use App\Http\Requests\KonversiObatRequest;
use App\Models\KonversiObat;
use App\Models\Obat;

class KonversiObatController extends Controller
{
    /**
     * Simpan konversi baru.
     */
    public function store(KonversiObatRequest $request, Obat $obat)
{
    $this->authorizeObat($obat);

    $data = $request->validated();

    if (!empty($data['is_default'])) {

        $obat->konversis()->update([
            'is_default' => false
        ]);

    }

    // Menentukan urutan otomatis
    $data['urutan'] = $obat->konversis()->max('urutan') + 1;

    $obat->konversis()->create($data);

    return redirect()
        ->route('obats.show', $obat)
        ->with('success', 'Konversi berhasil ditambahkan.');
}

    /**
     * Ambil data konversi untuk modal edit.
     */
    public function edit(KonversiObat $konversi)
    {
        $this->authorizeObat($konversi->obat);

        return response()->json($konversi);
    }

    /**
     * Update konversi.
     */
    public function update(
        KonversiObatRequest $request,
        KonversiObat $konversi
    ) {
        $this->authorizeObat($konversi->obat);

        $data = $request->validated();

        if (!empty($data['is_default'])) {

            $konversi->obat
                ->konversis()
                ->update([
                    'is_default' => false
                ]);
        }

        $konversi->update($data);

        return redirect()
            ->route('obats.show', $konversi->obat)
            ->with('success', 'Konversi berhasil diperbarui.');
    }

    /**
     * Hapus konversi.
     */
    public function destroy(KonversiObat $konversi)
    {
        $this->authorizeObat($konversi->obat);

        $obat = $konversi->obat;

        $konversi->delete();

        return redirect()
            ->route('obats.show', $obat)
            ->with('success', 'Konversi berhasil dihapus.');
    }

    /**
     * Validasi akses obat.
     */
    private function authorizeObat(Obat $obat)
    {
        if (
            !auth()->user()->isSuperAdmin() &&
            $obat->apotek_id != auth()->user()->apotek_id
        ) {
            abort(403);
        }
    }
}
