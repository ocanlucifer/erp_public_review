<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoAccMaterialTable extends Migration
{
    public function up()
    {
        Schema::create('po_acc_material', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_poacc');
            $table->integer('id_sales_order')->nullable();
            $table->integer('id_fabricconst')->nullable();
            $table->integer('id_fabriccomp')->nullable();
            $table->integer('id_style')->nullable();
            $table->string('fabric_desc')->nullable();
            $table->date('shipping_date');
            $table->double('budget',12,2)->nullable();
            $table->string('material_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('po_acc_material');
    }
}
