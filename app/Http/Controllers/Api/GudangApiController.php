<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gudang;

class GudangApiController extends Controller
{
    /**
     * Mengambil daftar ruangan berdasarkan gudang.
     */
    public function ruangans(Gudang $gudang)
    {
        $ruangans = $gudang->ruangans()
            ->orderBy('nama_ruangan')
            ->get([
                'id',
                'nama_ruangan'
            ]);

        return response()->json($ruangans);
    }
}
