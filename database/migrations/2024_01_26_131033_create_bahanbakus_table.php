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
        Schema::create('bahanbakus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan');
            $table->enum('jenis', ['bahan baku', 'bahan penolong', 'kardus']);
            $table->string('satuan');
            $table->integer('banyak_satuan')->nullable();
            $table->enum('jenis_satuan', ['Kg', 'Gr', 'Biji'])->nullable();
            $table->integer('harga_persatuan');
            $table->integer('harga_perkilo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahanbakus');
    }
};
