<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkerFabricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marker_fabric', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_marker');
            $table->integer('id_fabric_construct');
            $table->integer('id_fabric_compost');
            $table->string('name');
            $table->string('description');
            $table->integer('gramasi');
            $table->string('unit');
            $table->string('marker_type');
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
        Schema::dropIfExists('marker_fabric');
    }
}
