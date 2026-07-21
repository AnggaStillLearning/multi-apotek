<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

            // Master Obat
            $table->string('nama_obat');

            // Harga beli default
            $table->decimal('harga_beli_default', 12, 2)->default(0);

            // Batas minimum stok
            $table->integer('stok_minimum')->default(10);

            // Total stok seluruh batch
            $table->integer('total_stok')->default(0);

            // Keterangan obat
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
