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
        Schema::create('resep_wips', function (Blueprint $table) {
            $table->id();
            $table->string('nama_wip');
            $table->string('lini_produksi');
            $table->string('nama_komposisi');
            $table->integer('gram');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_wips');
    }
};
