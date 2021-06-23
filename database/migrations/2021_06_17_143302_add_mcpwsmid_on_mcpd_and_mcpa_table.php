<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMcpwsmidOnMcpdAndMcpaTable extends Migration
{
    public function up()
    {
        Schema::table('mcp_detail', function (Blueprint $table) {
            $table->integer('id_mcpwsm')->after('mcp');
        });

        Schema::table('mcp_assort', function (Blueprint $table) {
            $table->integer('id_mcpwsm')->after('mcp');
        });
    }

    public function down()
    {
        //
    }
}
