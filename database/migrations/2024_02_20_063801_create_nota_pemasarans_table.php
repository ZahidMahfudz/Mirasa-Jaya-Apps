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
        Schema::create('nota_pemasarans', function (Blueprint $table) {
            $table->string('id_nota')->primary();
            $table->enum('jenis_nota', ['nota_cash', 'nota_noncash']);
            $table->date('tanggal');
            $table->string('nama_toko');
            $table->enum('status', ['lunas', 'belum_lunas']);
            $table->string('keterangan')->nullable();
            $table->decimal('total_nota', 15, 2);
            $table->string('oleh')->nullable();
            $table->date('tanggal_lunas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nota_pemasarans');
    }
};
