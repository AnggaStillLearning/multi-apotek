<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->integer('total_stok')
                  ->default(0)
                  ->after('stok_minimum');
        });
    }

    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn('total_stok');
        });
    }
};
