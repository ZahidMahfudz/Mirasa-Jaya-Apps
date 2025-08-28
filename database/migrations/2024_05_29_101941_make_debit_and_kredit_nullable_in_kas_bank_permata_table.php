<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kas_bank_permata', function (Blueprint $table) {
            $table->decimal('debit', 15, 2)->nullable()->change();
            $table->decimal('kredit', 15, 2)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('kas_bank_permata', function (Blueprint $table) {
            $table->decimal('debit', 15, 2)->nullable(false)->change();
            $table->decimal('kredit', 15, 2)->nullable(false)->change();
        });
    }
};
