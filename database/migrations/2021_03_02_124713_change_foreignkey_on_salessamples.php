<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignkeyOnSalessamples extends Migration
{
    public function up()
    {
        Schema::table('salessamples', function (Blueprint $table) {
            $table->dropColumn('code_customer');
            $table->dropColumn('id_style');
            $table->dropColumn('id_brand');
            $table->dropColumn('garment_type');
            $table->dropColumn('sample_type');
        });

        Schema::table('salessamples', function (Blueprint $table) {
            $table->string('customer')->after('delivery_date');
            $table->string('style')->after('state');
            $table->string('brand')->after('art_number');
            $table->string('garment_type')->after('season');
            $table->string('sample_type')->after('style_group');
        });
    }

    public function down()
    {
    }
}
