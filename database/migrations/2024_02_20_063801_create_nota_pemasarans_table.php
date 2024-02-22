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
            $table->id();
            $table->enum('jenis_nota', ['nota_cash', 'nota_noncash']);
            $table->date('tanggal');
            $table->string('nama_toko');
            $table->integer('qty');
            $table->string('nama_barang');
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
