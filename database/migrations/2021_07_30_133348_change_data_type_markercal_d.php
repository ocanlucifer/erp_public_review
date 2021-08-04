<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDataTypeMarkercalD extends Migration
{
    public function up()
    {
        Schema::table('markercal_d', function (Blueprint $table) {
            $table->dropColumn('pjg_m', 'lbr_m', 'tole_pjg_m', 'tole_lbr_m', 'efficiency', 'perimeter', 'total_scale', 'state');
        });

        Schema::table('markercal_d', function (Blueprint $table) {
            $table->float('pjg_m')->after('pdf_marker')->nullable();
            $table->float('lbr_m')->after('pjg_m')->nullable();
            $table->float('tole_pjg_m')->after('lbr_m')->nullable();
            $table->float('tole_lbr_m')->after('tole_pjg_m')->nullable();
            $table->float('efficiency')->after('tole_lbr_m')->nullable();
            $table->float('perimeter')->after('efficiency')->nullable();
            $table->float('total_scale')->after('perimeter')->nullable();
            $table->string('state')->default('UNCONFIRMED')->after('ordering');
        });
    }

    public function down()
    {
    }
}
