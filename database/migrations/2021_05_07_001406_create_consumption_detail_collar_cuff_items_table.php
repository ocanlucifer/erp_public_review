<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionDetailCollarCuffItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption_detail_collar_cuff_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cons_sup');
            $table->string('unit');
            $table->integer('id_color');
            $table->float('total_qty');
            $table->float('tole');
            $table->float('qty_unit');
            $table->float('total_qty_unit_pcs');
            $table->float('total_qty_unit');
            $table->float('freight');
            $table->float('budget_price');
            $table->float('supplier_price');
            $table->float('amount');
            $table->float('amount_freight');
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
        Schema::dropIfExists('consumption_detail_collar_cuff_item');
    }
}
