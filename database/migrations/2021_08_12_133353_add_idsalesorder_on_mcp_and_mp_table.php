<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdsalesorderOnMcpAndMpTable extends Migration
{
    public function up()
    {
        Schema::table('mcp', function (Blueprint $table) {
            $table->integer('id_sales_order')->after('id')->nullable();
        });

        Schema::table('mp', function (Blueprint $table) {
            $table->integer('id_sales_order')->after('id')->nullable();
        });
    }

    public function down()
    {
        //
    }
}
