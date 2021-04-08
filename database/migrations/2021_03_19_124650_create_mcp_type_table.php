<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcpTypeTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mcp');
            $table->integer('id_wsheet');
            $table->integer('no_urut');
            $table->string('type');
            $table->string('fabricconst');
            $table->string('fabriccomp');
            $table->string('fabricdesc');
            $table->string('component');
            $table->string('warna');
            $table->string('tujuan');
            $table->string('remark');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_type');
    }
}
