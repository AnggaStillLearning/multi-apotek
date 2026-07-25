<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_obats', function (Blueprint $table) {

            $table->id();

            // Master Obat
            $table->foreignId('obat_id')
                ->constrained()
                ->cascadeOnDelete();

            // Lokasi Penyimpanan
            $table->foreignId('gudang_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('ruangan_id')
                ->constrained()
                ->cascadeOnDelete();

            // Nomor Batch
            $table->string('nomor_batch');

            // Kadaluarsa
            $table->date('tanggal_kadaluarsa')->nullable();

            // Persediaan
            $table->integer('stok')->default(0);

            // Harga beli batch
            $table->decimal('harga_beli',15,2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_obats');
    }
};
