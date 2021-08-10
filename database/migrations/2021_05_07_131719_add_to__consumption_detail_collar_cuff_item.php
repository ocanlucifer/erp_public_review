<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToConsumptionDetailCollarCuffItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumption_detail_collar_cuff_item', function (Blueprint $table) {
            $table->string('dimension');
            $table->string('size');
            $table->float('total');
            $table->float('total_tolerance');
            $table->float('total_rounded');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
