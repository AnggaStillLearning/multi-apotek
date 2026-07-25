<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Obat;

class KonversiApiController extends Controller
{
    public function index(Obat $obat)
    {
        $konversis = $obat->konversis()
            ->with('satuan')
            ->orderBy('urutan')
            ->get();

        return response()->json($konversis);
    }
}
