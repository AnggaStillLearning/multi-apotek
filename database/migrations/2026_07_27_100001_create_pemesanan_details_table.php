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
        Schema::create('pemesanan_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pemesanan_id')
                ->constrained()
                ->cascadeOnDelete();

            // Baru pilih Obat + satuan di tahap ini. Batch/gudang/ruangan
            // spesifik ditentukan nanti lewat FEFO saat checkout (di Pembelian),
            // karena stok fisik & lokasi bisa berubah selama barang di keranjang.
            $table->foreignId('obat_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('konversi_obat_id')
                ->constrained()
                ->cascadeOnDelete();

            // jumlah sesuai satuan yang dipilih (misal 2 Box)
            $table->integer('qty');

            // snapshot harga_jual dari konversi_obat saat ditambahkan ke keranjang,
            // supaya kalau harga jual diubah admin nanti, keranjang lama tidak ikut berubah.
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
        Schema::dropIfExists('pemesanan_details');
    }
};
