<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoremarkTable extends Migration
{
    public function up()
    {
        Schema::create('soremark', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_remark_type');
            $table->integer('id_sales_order');
            $table->longText('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soremark');
    }
}
