<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialreqsTable extends Migration
{
    public function up()
    {
        Schema::create('materialreqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->integer('id_fabric_construct');
            $table->integer('id_fabric_compost');
            $table->longText('fabric_description');
            $table->integer('budget');
            $table->string('po_status');
            $table->string('state');
            $table->integer('id_purchasing');
            $table->longText('note');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materialreqs');
    }
}
