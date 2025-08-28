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
        Schema::create('gaji_karyawans', function (Blueprint $table) {
            $table->string('id_gaji')->primary();
            $table->string('id_karyawan');
            $table->date('tanggal_gaji');
            $table->decimal('jumlah_masuk', 8, 2);
            $table->decimal('jumlah_bonus', 8, 2);
            $table->decimal('total_gaji', 8, 2);
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('data__karyawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_karyawans');
    }
};
