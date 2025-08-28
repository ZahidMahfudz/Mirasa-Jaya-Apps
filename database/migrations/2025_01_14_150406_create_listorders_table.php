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
        Schema::create('listorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('preorder_id');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->timestamps();

            $table->foreign('preorder_id')->references('id')->on('preorders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listorders');
    }
};
