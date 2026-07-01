<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisObat;

class JenisObatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            ['nama' => 'Tablet'],
            ['nama' => 'Sirup'],
            ['nama' => 'Kapsul'],
            ['nama' => 'Salep'],
            ['nama' => 'Tetes'],
            ['nama' => 'Injeksi'],

        ];

        foreach ($data as $item) {

            JenisObat::create($item);

        }
    }
}
