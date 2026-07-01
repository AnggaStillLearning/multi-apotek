<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {

            $table->id();

            // Relasi Apotek
            $table->foreignId('apotek_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi Jenis Obat
            $table->foreignId('jenis_obat_id')
                ->constrained('jenis_obats')
                ->cascadeOnDelete();

            // Relasi Kategori
            $table->foreignId('kategori_id')
                ->constrained('kategoris')
                ->cascadeOnDelete();

            // Informasi Obat
            $table->string('nama_obat');

            // Batch obat
            $table->string('batch');

            // Harga
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);

            // Persediaan
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(10);

            // Kadaluarsa
            $table->date('tanggal_kadaluarsa');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
