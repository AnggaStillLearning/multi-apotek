<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('apotek_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->dateTime('tanggal_penjualan');

            $table->decimal('subtotal', 15, 2)->default(0);

            $table->decimal('grand_total', 15, 2)->default(0);

            $table->string('metode_pembayaran');

            $table->string('status')->default('Pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
