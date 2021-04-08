<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemarkTable extends Migration
{
    public function up()
    {
        Schema::create('remark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_remark_type');
            $table->integer('id_sales_sample');
            $table->longText('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remark');
    }
}
