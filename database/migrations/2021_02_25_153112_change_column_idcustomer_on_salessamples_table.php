<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnIdcustomerOnSalessamplesTable extends Migration
{

    public function up()
    {
        Schema::table('salessamples', function (Blueprint $table) {
            $table->dropColumn('id_customer');
        });
        Schema::table('salessamples', function (Blueprint $table) {
            $table->string('id_customer')->after('delivery_date');
        });
    }

    public function down()
    {
    }
}
