<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcpAssortTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_assort', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_mcpd');
            $table->string('size');
            $table->integer('qty_ws');
            $table->integer('scale');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_assort');
    }
}
