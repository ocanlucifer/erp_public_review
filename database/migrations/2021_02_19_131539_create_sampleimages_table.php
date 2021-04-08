<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSampleimagesTable extends Migration
{
    public function up()
    {
        Schema::create('sampleimages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sales_sample');
            $table->string('image_type');
            $table->string('source');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sampleimages');
    }
}
