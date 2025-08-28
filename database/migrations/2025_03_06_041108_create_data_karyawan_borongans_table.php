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
        Schema::create('data_karyawan_borongans', function (Blueprint $table) {
            $table->string('id_karyawan_borongan')->primary();
            $table->string('nama_karyawan');
            $table->string('bagian');
            $table->decimal('harga_s', 8, 2);
            $table->decimal('harga_o', 8, 2);
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
        Schema::dropIfExists('data_karyawan_borongans');
    }
};
