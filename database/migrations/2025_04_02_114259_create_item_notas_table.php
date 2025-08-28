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
        Schema::create('item_notas', function (Blueprint $table) {
            $table->string('id_item_nota')->primary();
            $table->string('id_nota');
            $table->string('nama_produk');
            $table->decimal('qty', 15, 2)->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();

            $table->foreign('id_nota')->references('id_nota')->on('nota_pemasarans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_notas');
    }
};
