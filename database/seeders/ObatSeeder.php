<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            [

                'apotek_id' => 1,

                'jenis_obat_id' => 1,

                'kategori_id' => 1,

                'nama_obat' => 'Paracetamol',

                'batch' => 'A001',

                'harga_beli' => 5000,

                'harga_jual' => 8000,

                'stok' => 10,

                'stok_minimum' => 5,

                'tanggal_kadaluarsa' => '2026-12-31',

            ],

            [

                'apotek_id' => 1,

                'jenis_obat_id' => 1,

                'kategori_id' => 1,

                'nama_obat' => 'Paracetamol',

                'batch' => 'A002',

                'harga_beli' => 5000,

                'harga_jual' => 8000,

                'stok' => 50,

                'stok_minimum' => 5,

                'tanggal_kadaluarsa' => '2027-12-31',

            ],

            [

                'apotek_id' => 1,

                'jenis_obat_id' => 3,

                'kategori_id' => 1,

                'nama_obat' => 'Amoxicillin',

                'batch' => 'B001',

                'harga_beli' => 7000,

                'harga_jual' => 10000,

                'stok' => 30,

                'stok_minimum' => 10,

                'tanggal_kadaluarsa' => '2027-10-10',

            ],

        ];

        foreach ($data as $item) {

            Obat::create($item);

        }
    }
}
