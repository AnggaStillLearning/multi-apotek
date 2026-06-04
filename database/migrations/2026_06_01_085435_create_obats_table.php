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

        $table->foreignId('apotek_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('nama_obat');
        $table->decimal('harga_beli', 12, 2)->default(0);
        $table->decimal('harga_jual', 12, 2)->default(0);

        $table->integer('stok')->default(0);
        $table->integer('stok_minimum')->default(10);

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
