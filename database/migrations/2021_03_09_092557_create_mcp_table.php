<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcpTable extends Migration
{
    public function up()
    {
        Schema::create('mcp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('order_name');
            $table->string('fabric_const');
            $table->string('fabric_comp');
            $table->string('fabric_desc');
            $table->string('style');
            $table->string('style_desc');
            $table->date('delivery_date');
            $table->string('revision_count');
            $table->string('revisi_remark');
            $table->string('state');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp');
    }
}
