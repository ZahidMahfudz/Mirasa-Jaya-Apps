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
        Schema::create('uangmasukpiutangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->date('tanggal_lunas')->nullable();
            $table->string('nama_toko');
            $table->string('keterangan');
            $table->integer('total_piutang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uangmasukpiutangs');
    }
};
