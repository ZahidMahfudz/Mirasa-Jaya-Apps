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
        Schema::create('data__karyawans', function (Blueprint $table) {
            $table->string('id_karyawan')->primary();
            $table->string('nama_karyawan');
            $table->string('bagian');
            $table->string('posisi');
            $table->decimal('gaji_pokok', 8, 2);
            $table->decimal('makan', 8, 2);
            $table->decimal('tunjangan', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data__karyawans');
    }
};
