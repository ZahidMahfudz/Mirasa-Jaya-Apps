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
        Schema::create('hutangbahanbakus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->date('tanggal_lunas')->nullable();
            $table->string('nama_bahan');
            $table->integer('qty');
            $table->string('satuan');
            $table->integer('harga_satuan');
            $table->integer('ppn')->nullable();
            $table->integer('jumlah');
            $table->string('supplier');
            $table->enum('status', ['lunas', 'belum_lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutangbahanbakus');
    }
};
