<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_quot_header', 30);
            $table->string('jenis')->nullable(); //fabrication,specialtrims,trims,embelishment,washing,miscelleneous
            $table->string('position')->nullable();
            $table->text('jenis_detail')->nullable(); 
            $table->text('description')->nullable();
            $table->string('supplier')->nullable();
            $table->float('width')->nullable();
            $table->float('cons')->nullable();
            $table->float('allowance')->nullable();
            $table->float('price')->nullable();
            $table->float('freight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_detail');
    }
}
