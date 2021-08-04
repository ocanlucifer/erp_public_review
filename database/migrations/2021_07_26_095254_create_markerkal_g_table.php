<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerkalGTable extends Migration
{
    public function up()
    {
        Schema::create('markercal_g', function (Blueprint $table) {
            $table->bigIncrements('id_markercal_g');
            $table->integer('id_markercal_d');
            $table->float('gramasi');
            $table->float('kgdz')->nullable();
            $table->float('yddz')->nullable();
            $table->float('mddz')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markerkal_g');
    }
}
