<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizespecsTable extends Migration
{
    public function up()
    {
        Schema::create('sizespecs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_sample');
            $table->integer('id_size');
            $table->string('value');
            $table->string('specification');
            $table->string('allowance');
            $table->integer('position');
            $table->string('unit');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sizespecs');
    }
}
