<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSomaterialDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('somaterial_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_order');
            $table->integer('id_material_req');
            $table->string('gmt_color');
            $table->string('gmt_size');
            $table->string('mat_color');
            $table->string('mat_size');
            $table->integer('quantity');
            $table->integer('consumption');
            $table->integer('per_garment');
            $table->string('unit');
            $table->integer('wastage');
            $table->string('status');
            $table->longText('note');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('somaterial_details');
    }
}
