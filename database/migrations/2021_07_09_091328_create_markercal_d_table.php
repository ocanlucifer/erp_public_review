<?php

use Carbon\Exceptions\InvalidPeriodParameterException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkercalDTable extends Migration
{
    public function up()
    {
        Schema::create('markercal_d', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_markercal');
            $table->string('fabricconst');
            $table->string('fabriccomp');
            $table->string('kode')->nullable();
            $table->date('calculation_date')->nullable();
            $table->string('size_name')->nullable();
            $table->string('pdf_marker')->nullable();
            $table->integer('pjg_m')->nullable();
            $table->integer('lbr_m')->nullable();
            $table->integer('tole_pjg_m')->nullable();
            $table->integer('tole_lbr_m')->nullable();
            $table->string('efficiency')->nullable();
            $table->integer('perimeter')->nullable();
            $table->integer('total_scale')->nullable();
            $table->string('color_name')->nullable();
            $table->integer('revision')->nullable();
            $table->string('fabric_type')->nullable();
            $table->longText('remark')->nullable();
            $table->longText('revisionRemark')->nullable();
            $table->integer('ordering')->nullable();
            $table->string('state')->default('created');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markercal_d');
    }
}
