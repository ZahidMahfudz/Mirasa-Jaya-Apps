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
        Schema::create('gaji_karyawan_borongans', function (Blueprint $table) {
            $table->string('id_gaji_borongan')->primary();
            $table->string('id_karyawan_borongan');
            $table->date('tanggal_gaji');
            $table->decimal('jumlah_s', 8, 2);
            $table->decimal('jumlah_o', 8, 2);
            $table->decimal('jumlah_masuk', 8, 2);
            $table->decimal('jumlah_bonus', 8, 2);
            $table->decimal('total_gaji', 8, 2);
            $table->timestamps();

            $table->foreign('id_karyawan_borongan')->references('id_karyawan_borongan')->on('data_karyawan_borongans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_karyawan_borongans');
    }
};
