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
        Schema::create('pembelians', function (Blueprint $table) {

            $table->id();

            $table->foreignId('apotek_id')
                ->constrained()
                ->cascadeOnDelete();

            // Hanya terisi untuk pembelian online yang berasal dari checkout
            // sebuah Pemesanan. Pembelian offline tidak melalui Pemesanan.
            $table->foreignId('pemesanan_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Pembeli terdaftar. Nullable karena pembelian offline boleh
            // walk-in tanpa akun (mengikuti pola Penjualan lama).
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Kasir yang menginput transaksi. Hanya terisi untuk jenis=offline.
            $table->foreignId('kasir_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nomor_pembelian')->unique();

            $table->enum('jenis', [
                'online',
                'offline'
            ]);

            $table->dateTime('tanggal_pembelian');

            $table->decimal('subtotal', 15, 2)->default(0);

            $table->decimal('grand_total', 15, 2)->default(0);

            $table->string('metode_pembayaran')->nullable();

            // menunggu_pembayaran : baru checkout (online), belum bayar
            // diproses            : pembayaran terkonfirmasi, STOK DIKURANGI di sini (via FEFO)
            // selesai             : barang sudah diambil/dikirim ke pembeli
            // dibatalkan
            $table->enum('status', [
                'menunggu_pembayaran',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');

            $table->text('keterangan')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
