<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama' => 'Generik'],
            ['nama' => 'Paten'],
            ['nama' => 'Obat Bebas'],
            ['nama' => 'Obat Bebas Terbatas'],
            ['nama' => 'Obat Keras'],

        ];

        foreach ($data as $item) {

            Kategori::create($item);

        }
    }
}
