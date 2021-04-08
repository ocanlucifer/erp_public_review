<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->string('code', 30)->primary();
            $table->string('cust')->nullable();
            $table->string('brand')->nullable();
            $table->string('season')->nullable();
            $table->string('style')->nullable();
            $table->text('description')->nullable();
            $table->string('bu')->nullable();
            $table->string('basis_order')->nullable();
            $table->float('forecast_qty')->nullable();
            $table->string('delivery')->nullable();
            $table->string('size_range')->nullable();
            $table->string('destination')->nullable();
            $table->date('tgl_quot')->nullable();
            $table->String('exchange_rate')->nullable();
            $table->float('smv')->nullable();
            $table->float('rate')->nullable();
            $table->float('handling')->nullable(); //persen nya
            $table->float('margin')->nullable(); //persennya
            $table->float('offer_price')->nullable();
            $table->float('sales_fee')->nullable(); //persennya
            $table->float('confirm_price')->nullable();
            $table->string('status');
            $table->bigInteger('create_by')->nullable();
            $table->bigInteger('update_by')->nullable();
            $table->date('update_tgl')->nullable();
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
        Schema::dropIfExists('quotation');
    }
}
