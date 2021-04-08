<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssortmentsTable extends Migration
{
    public function up()
    {
        Schema::create('assortments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_sample');
            $table->integer('id_size');
            $table->integer('id_color');
            $table->integer('quantity');
            $table->integer('tolerance');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assortments');
    }
}
