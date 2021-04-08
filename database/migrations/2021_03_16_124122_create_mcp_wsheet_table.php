<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcpWsheetTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_wsheet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mcp');
            $table->integer('mcp_wsheet_m');
            $table->integer('no_urut');
            $table->string('combo');
            $table->string('size');
            $table->integer('ws_qty');
            $table->integer('tolerance');
            $table->integer('qty_tot');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_wsheet');
    }
}
