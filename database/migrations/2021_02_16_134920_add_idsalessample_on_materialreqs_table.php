<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdsalessampleOnMaterialreqsTable extends Migration
{
    public function up()
    {
        Schema::table('materialreqs', function (Blueprint $table) {
            $table->integer('id_sales_sample');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materialreqs');
    }
}
