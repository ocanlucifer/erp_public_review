<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalcost extends Migration
{
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->float('total_cost')->nullable()->after('rate');
        });

    }

    public function down()
    {
        //
    }
}
