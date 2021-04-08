<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdOnSizesTable extends Migration
{
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table('sizes', function (Blueprint $table) {
            $table->bigIncrements('id');
        });
    }


    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
