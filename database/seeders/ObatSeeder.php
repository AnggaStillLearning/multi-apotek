<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $obats = [

            [
                'apotek_id' => 1,
                'kategori_id' => 1,
                'nama_obat' => 'Paracetamol 500mg',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
                'stok' => 100,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => '2027-12-31',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 2,
                'nama_obat' => 'Amoxicillin 500mg',
                'harga_beli' => 7000,
                'harga_jual' => 10000,
                'stok' => 80,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => '2027-10-15',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 3,
                'nama_obat' => 'Vitamin C 500mg',
                'harga_beli' => 3000,
                'harga_jual' => 6000,
                'stok' => 150,
                'stok_minimum' => 30,
                'tanggal_kadaluarsa' => '2028-01-01',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 4,
                'nama_obat' => 'Cetirizine',
                'harga_beli' => 4000,
                'harga_jual' => 7000,
                'stok' => 60,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => '2027-08-10',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 5,
                'nama_obat' => 'Omeprazole',
                'harga_beli' => 6000,
                'harga_jual' => 9000,
                'stok' => 70,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => '2027-11-20',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 1,
                'nama_obat' => 'Ibuprofen',
                'harga_beli' => 6000,
                'harga_jual' => 9000,
                'stok' => 120,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => '2028-02-15',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 2,
                'nama_obat' => 'Cefadroxil',
                'harga_beli' => 9000,
                'harga_jual' => 13000,
                'stok' => 50,
                'stok_minimum' => 10,
                'tanggal_kadaluarsa' => '2027-09-18',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 3,
                'nama_obat' => 'Vitamin D',
                'harga_beli' => 4000,
                'harga_jual' => 7000,
                'stok' => 90,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => '2028-03-01',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 4,
                'nama_obat' => 'Loratadine',
                'harga_beli' => 5000,
                'harga_jual' => 8000,
                'stok' => 65,
                'stok_minimum' => 15,
                'tanggal_kadaluarsa' => '2027-10-10',
            ],

            [
                'apotek_id' => 1,
                'kategori_id' => 5,
                'nama_obat' => 'Antasida DOEN',
                'harga_beli' => 3500,
                'harga_jual' => 6000,
                'stok' => 110,
                'stok_minimum' => 20,
                'tanggal_kadaluarsa' => '2028-01-20',
            ],

        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
