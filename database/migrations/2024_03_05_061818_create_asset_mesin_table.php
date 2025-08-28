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
        Schema::create('asset_mesin', function (Blueprint $table) {
            $table->id();
            $table->string('mesin/alat');
            $table->enum('jenis',['Bagelen','Bolu_Panggang','Spet_Manual','Resep','Oven_Rotary','Mikser','Mesin_Kukies','Timbangan_Digital','Rak_Trolley_&_Loyang','Alat_Pendukung_Produksi']);
            $table->integer('jumlah_unit');
            $table->unsignedBigInteger('harga_beli');
            $table->unsignedBigInteger('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_mesin');
    }
};
