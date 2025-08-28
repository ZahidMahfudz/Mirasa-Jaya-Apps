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
        Schema::create('piutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_piutang');
            $table->date('tanggal_lunas')->nullable();
            $table->string('nama_toko');
            $table->string('Keterangan');
            $table->integer('total_piutang');
            $table->string('oleh');
            $table->enum('status', ['lunas', 'belum_lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piutangs');
    }
};
