<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsumptionsTable extends Migration
{
    public function up()
    {
        Schema::create('consumptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('code_quotation');
            $table->string('customer');
            $table->string('customer_style');
            $table->string('number_mp');
            $table->string('size_tengah');
            $table->date('delivery_date');
            $table->date('references_date');
            $table->float('net_price');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumptions');
    }
}
