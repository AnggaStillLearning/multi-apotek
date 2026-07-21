<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('obats', function (Blueprint $table) {

            $table->foreignId('ruangan_id')
                ->nullable()
                ->after('apotek_id')
                ->constrained()
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('obats', function (Blueprint $table) {

            $table->dropConstrainedForeignId('ruangan_id');

        });
    }
};
