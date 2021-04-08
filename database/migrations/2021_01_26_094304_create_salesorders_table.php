<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesordersTable extends Migration
{
    public function up()
    {
        Schema::create('salesorders', function (Blueprint $table) {
            // order/cust info
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('code_quotation');
            $table->date('order_date');
            $table->date('delivery_date');
            $table->integer('id_customer');
            $table->string('agent');
            $table->string('no_consumption');
            $table->string('state');
            // style
            $table->integer('id_style');
            $table->string('art_number');
            $table->integer('id_brand');
            $table->string('season');
            // detail
            $table->string('garment_type');
            $table->string('style_group');
            $table->string('cust_style_name');
            // remark
            $table->string('description');
            $table->string('revision_note');
            // timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salesorders');
    }
}
