<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoAccConvertUnitTable extends Migration
{
    public function up()
    {
        Schema::create('po_acc_convert_unit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_poacc');
            $table->integer('id_source_unit');
            $table->integer('id_target_unit');
            $table->double('faktor',8,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('po_acc_convert_unit');
    }
}
