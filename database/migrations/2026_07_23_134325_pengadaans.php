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
        Schema::create('pengadaans', function (Blueprint $table) {

    $table->id();

    $table->foreignId('supplier_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('apotek_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->foreignId('user_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('nomor_pengadaan')->unique();

    $table->date('tanggal_pengadaan');

    $table->decimal('subtotal', 15, 2)->default(0);

    $table->decimal('grand_total', 15, 2)->default(0);

    $table->enum('status', [
        'draft',
        'selesai',
        'dibatalkan'
    ])->default('draft');

    $table->text('keterangan')->nullable();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
