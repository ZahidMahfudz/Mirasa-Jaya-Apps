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
            if (!Schema::hasColumn('kas_bank_permata', 'saldo')) {
                $table->bigInteger('saldo')->unsigned()->notNull();
            }
        });
    }
    
    public function down()
    {
        Schema::table('kas_bank_permata', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};
