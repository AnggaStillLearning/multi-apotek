<?php

namespace App\Http\Controllers;

use App\Models\Obat;

class LandingController extends Controller
{
    public function index()
    {
        $obats = Obat::with('apotek')
            ->latest()
            ->take(8)
            ->get();

        return view(
            'landing.home',
            compact('obats')
        );
    }
}
