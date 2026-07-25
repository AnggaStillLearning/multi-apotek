<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konversi_obats', function (Blueprint $table) {

            $table->id();

            $table->unique([
                'obat_id',
                'satuan_id'
            ]);
            $table->foreignId('obat_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('satuan_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->unsignedInteger('urutan');

            $table->unsignedInteger('rasio_turun')
                  ->nullable();

            $table->unsignedInteger('isi');

            // Jumlah satuan dasar

            $table->decimal('harga_jual',15,2);

            $table->boolean('is_default')
                  ->default(false);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konversi_obats');
    }
};
