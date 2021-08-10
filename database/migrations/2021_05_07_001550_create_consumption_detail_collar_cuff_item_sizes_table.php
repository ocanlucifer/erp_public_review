<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionDetailCollarCuffItemSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption_detail_collar_cuff_item_size', function (Blueprint $table) {
            $table->id();
            $table->integer('id_collar_cuff');
            $table->string('dimension');
            $table->integer('id_size');
            $table->float('total');
            $table->float('total_tole');
            $table->float('total_rounded');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumption_detail_collar_cuff_item_size');
    }
}
