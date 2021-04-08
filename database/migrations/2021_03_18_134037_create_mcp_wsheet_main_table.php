<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcpWsheetMainTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_wsheet_main', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mcp');
            $table->integer('no_urut');
            $table->string('combo');
            $table->integer('total_qty');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_wsheet_main');
    }
}
