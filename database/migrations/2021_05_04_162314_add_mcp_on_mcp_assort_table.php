<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMcpOnMcpAssortTable extends Migration
{
    public function up()
    {
        Schema::table('mcp_assort', function (Blueprint $table) {
            $table->string('mcp')->after('id');
        });
    }

    public function down()
    {
        //
    }
}
