<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Apotek;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    public function run(): void
        { foreach (Apotek::all() as $apotek) {

        Gudang::create([

            'apotek_id' => $apotek->id,

            'nama_gudang' => 'Gudang Utama',

            'alamat' => $apotek->alamat,

            'status' => 'aktif'

            ]);

            }
        }
}
