<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ObatFactory extends Factory
{
    public function definition(): array
    {
        $namaObat = [

            'Paracetamol 500 mg',
            'Amoxicillin 500 mg',
            'Ibuprofen',
            'Vitamin C',
            'Cetirizine',
            'Omeprazole',
            'Amlodipine',
            'Captopril',
            'Metformin',
            'Simvastatin',
            'OBH Sirup',
            'Antasida DOEN',
            'Loratadine',
            'Mefenamic Acid',
            'Cefadroxil',
            'Salep Kulit',
            'Tetes Mata',
            'Vitamin D',
            'Zinc',
            'Asam Folat',

        ];

        return [

            'apotek_id' => 1,

            'jenis_obat_id' => fake()->numberBetween(1, 6),

            'kategori_id' => fake()->numberBetween(1, 5),

            'nama_obat' => fake()->randomElement($namaObat),

            'batch' => strtoupper(fake()->bothify('??###')),

            'harga_beli' => fake()->numberBetween(3000, 25000),

            'harga_jual' => fake()->numberBetween(5000, 35000),

            'stok' => fake()->numberBetween(5, 120),

            'stok_minimum' => fake()->numberBetween(5, 20),

            'tanggal_kadaluarsa' => fake()->dateTimeBetween('+2 months', '+2 years'),

        ];
    }
}
