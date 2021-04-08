<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveColumnIdsalessampleOnMaterialreqsTable extends Migration
{
    public function up()
    {
        Schema::table('materialreqs', function (Blueprint $table) {
            $table->dropColumn('id_sales_sample');
        });
        Schema::table('materialreqs', function (Blueprint $table) {
            $table->integer('id_sales_sample')->after('id');
        });
    }

    public function down()
    {
    }
}
