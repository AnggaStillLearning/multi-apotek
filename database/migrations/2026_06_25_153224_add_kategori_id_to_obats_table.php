<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obats', function (Blueprint $table) {

            $table->foreignId('kategori_id')
                  ->after('apotek_id')
                  ->constrained('kategoris')
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {

            $table->dropForeign(['kategori_id']);

            $table->dropColumn('kategori_id');

        });
    }
};
