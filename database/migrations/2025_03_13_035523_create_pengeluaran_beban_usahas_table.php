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
        Schema::create('pengeluaran_beban_usahas', function (Blueprint $table) {
            $table->string('id_pengeluaran_beban_usaha')->primary();
            $table->enum('jenis_pengeluaran', ['bb','akpro', 'akpem', 'perl', 'pera', 'pemba', 'gk', 'gd', 'm', 'lis', 'pajak', 'sos','st', 'project', 'thr']);
            $table->date('tanggal_pengeluaran');
            $table->string('keterangan');
            $table->decimal('qty', 8, 2)->nullable();
            $table->decimal('harga_satuan', 8, 2)->nullable();
            $table->decimal('total_pengeluaran', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_beban_usahas');
    }
};
