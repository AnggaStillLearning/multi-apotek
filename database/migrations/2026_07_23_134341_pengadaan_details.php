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
        Schema::create('pengadaan_details', function (Blueprint $table) {

    $table->id();

    $table->foreignId('pengadaan_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('obat_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('konversi_obat_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('gudang_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('ruangan_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('nomor_batch');

    $table->date('tanggal_kadaluarsa')->nullable();

    // jumlah sesuai konversi (misal 5 Box)
    $table->integer('qty');

    // jumlah satuan dasar (hasil konversi)
    $table->integer('qty_dasar');

    $table->decimal('harga_beli', 15, 2);

    $table->decimal('subtotal', 15, 2);

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_details');
    }
};
