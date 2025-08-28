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
        Schema::create('drop_outs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_pengambil');
            $table->enum('status', ['proses', 'diambil']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drop_outs');
    }
};
