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
        Schema::create('list_drop_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drop_out_id');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->timestamps();

            $table->foreign('drop_out_id')->references('id')->on('drop_outs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_drop_outs');
    }
};
