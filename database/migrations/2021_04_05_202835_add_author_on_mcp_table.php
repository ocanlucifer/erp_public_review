<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorOnMcpTable extends Migration
{
    public function up()
    {
        Schema::table('mcp', function (Blueprint $table) {
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('confirmed_by');
        });
    }

    public function down()
    {
        //
    }
}
