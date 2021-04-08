<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoassortmentsTable extends Migration
{

    public function up()
    {
        Schema::create('so_assortments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_order');
            $table->integer('id_size');
            $table->integer('id_color');
            $table->integer('quantity');
            $table->integer('tolerance');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soassortments');
    }
}
