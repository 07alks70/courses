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
        if (Schema::hasTable('diplomas')){
            if (Schema::hasColumns('diplomas', ['hypotheses', 'graphics'])){
                Schema::table('diplomas', function (Blueprint $table){
                    $table->dropColumn('hypotheses');
                    $table->dropColumn('graphics');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
