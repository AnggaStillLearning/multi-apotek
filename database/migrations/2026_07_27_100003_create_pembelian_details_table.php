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
        Schema::create('pembelian_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pembelian_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('obat_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('konversi_obat_id')
                ->constrained()
                ->cascadeOnDelete();

            // Batch dipilih otomatis via FEFO (Fase 2) saat status pembelian
            // berubah jadi "diproses" (stok baru dikurangi di titik itu).
            // Karena itu masih nullable selagi status menunggu_pembayaran.
            $table->foreignId('batch_obat_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // jumlah sesuai satuan yang dibeli (misal 2 Box)
            $table->integer('qty');

            // snapshot isi (jumlah ke satuan dasar) dari konversi_obat saat dibeli
            $table->integer('isi');

            // snapshot harga beli batch, terisi setelah FEFO menentukan batch
            $table->decimal('harga_beli', 15, 2)->nullable();

            // snapshot harga_jual dari konversi_obat saat checkout
            $table->decimal('harga_jual', 15, 2);

            $table->decimal('subtotal', 15, 2);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};
