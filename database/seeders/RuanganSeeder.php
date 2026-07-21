<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Gudang::all() as $gudang) {

            $ruangan = [

                'Rak A',

                'Rak B',

                'Rak C',

                'Etalase',

                'Lemari Pendingin'

            ];

            foreach ($ruangan as $item) {

                Ruangan::create([

                    'gudang_id' => $gudang->id,

                    'nama_ruangan' => $item

                ]);

            }
        }
    }
}
