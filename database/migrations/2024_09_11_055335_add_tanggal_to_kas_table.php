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
        Schema::table('kas', function (Blueprint $table) {
            if (!Schema::hasColumn('kas', 'tanggal')) {
                $table->date('tanggal')->before('kas');
            } // Menambahkan kolom tanggal sebelum kolom kas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
