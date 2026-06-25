<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [

            [
                'nama_kategori' => 'Analgesik',
                'deskripsi' => 'Obat pereda nyeri',
                'icon' => '💊'
            ],

            [
                'nama_kategori' => 'Antibiotik',
                'deskripsi' => 'Obat infeksi bakteri',
                'icon' => '🦠'
            ],

            [
                'nama_kategori' => 'Vitamin',
                'deskripsi' => 'Suplemen vitamin',
                'icon' => '🍊'
            ],

            [
                'nama_kategori' => 'Antihistamin',
                'deskripsi' => 'Obat alergi',
                'icon' => '🌿'
            ],

            [
                'nama_kategori' => 'Obat Lambung',
                'deskripsi' => 'Obat gangguan lambung',
                'icon' => '🫃'
            ],

        ];

        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}
