<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRateToPpnTable extends Migration
{
    public function up()
    {
        Schema::table('ppn', function (Blueprint $table) {
            $table->float('rate');
        });
    }

    public function down()
    {
        Schema::table('ppn', function (Blueprint $table) {
            $table->float('rate');
        });
    }
}
