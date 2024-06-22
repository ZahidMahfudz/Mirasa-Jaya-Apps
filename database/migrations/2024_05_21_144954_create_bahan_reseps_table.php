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
        Schema::create('bahan_reseps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resep_id');
            $table->string('nama_bahan');
            $table->float('jumlah_bahan_gr', 8, 2)->default(0);
            $table->float('jumlah_bahan_kg', 8, 2)->default(0);
            $table->float('jumlah_bahan_zak', 8, 2)->default(0);
            $table->timestamps();

            $table->foreign('resep_id')->references('id')->on('reseps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_reseps');
    }
};
