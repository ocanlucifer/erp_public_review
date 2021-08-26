<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoAccMaterialBrTable extends Migration
{
    public function up()
    {
        Schema::create('po_acc_material_br', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_material');
            $table->integer('id_color');
            $table->integer('id_size');
            $table->integer('id_unit');
            $table->double('price',12,2);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('po_acc_material_br');
    }
}
