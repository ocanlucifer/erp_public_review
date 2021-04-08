<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnIdcustOnSalesorder extends Migration
{
    public function up()
    {
        Schema::table('salesorders', function (Blueprint $table) {
            $table->dropColumn('id_customer');
        });
        Schema::table('salesorders', function (Blueprint $table) {
            $table->string('code_customer')->after('delivery_date');
        });

        Schema::table('salessamples', function (Blueprint $table) {
            $table->dropColumn('id_customer');
        });
        Schema::table('salessamples', function (Blueprint $table) {
            $table->string('code_customer')->after('delivery_date');
        });
    }

    public function down()
    {
    }
}
