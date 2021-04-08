<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeIdstyleIdbrandOnSalesorders extends Migration
{
    public function up()
    {
        Schema::table('salesorders', function (Blueprint $table) {
            $table->dropColumn('id_style');
        });
        Schema::table('salesorders', function (Blueprint $table) {
            $table->dropColumn('id_brand');
        });

        Schema::table('salesorders', function (Blueprint $table) {
            $table->string('style')->after('state');
        });
        Schema::table('salesorders', function (Blueprint $table) {
            $table->string('brand')->after('art_number');
        });
    }

    public function down()
    {
    }
}
