<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkercalTable extends Migration
{
    public function up()
    {
        Schema::create('markercal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mc_number');
            $table->string('order');
            $table->string('style')->nullable();
            $table->string('combo')->nullable();
            $table->string('numbering');
            $table->string('fabricconst')->nullable();
            $table->string('fabriccomp')->nullable();
            $table->integer('revision')->nullable();
            $table->text('memo')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('state')->default('created');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('markercal');
    }
}
