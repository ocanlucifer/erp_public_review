<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoimageTable extends Migration
{
    public function up()
    {
        Schema::create('soimages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_order');
            $table->string('image_type');
            $table->string('source');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soimage');
    }
}
