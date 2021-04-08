<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkerDescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marker_desc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('markerfab_id');
            $table->float('width');
            $table->float('quantity');
            $table->float('consumption');
            $table->float('efficiency');
            $table->float('qty_unit');
            $table->float('act_unit');
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
        Schema::dropIfExists('marker_desc');
    }
}
