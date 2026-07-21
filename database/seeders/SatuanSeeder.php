<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            'Tablet',
            'Kapsul',
            'Strip',
            'Box',
            'Botol',
            'Sachet',
            'Vial',
            'Ampul',
            'Tube',
            'Pcs'

        ];

        foreach ($data as $item) {

            Satuan::create([

                'nama_satuan' => $item

            ]);

        }
    }
}
