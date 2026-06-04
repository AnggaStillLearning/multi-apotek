<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apotek;

class ApotekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Apotek::create([
        'nama_apotek' => 'Apotek Jaya',
        'alamat' => 'Banjarmasin'
    ]);
}
}
