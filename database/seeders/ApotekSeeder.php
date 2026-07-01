<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apotek;

class ApotekSeeder extends Seeder
{
    public function run(): void
    {
        Apotek::create([

            'nama_apotek' => 'Apotek Sehat Sentosa',

            'alamat' => 'Jl. Ahmad Yani No. 10, Banjarmasin',

            'latitude' => -3.3194370,

            'longitude' => 114.5907530,

        ]);
    }
}
