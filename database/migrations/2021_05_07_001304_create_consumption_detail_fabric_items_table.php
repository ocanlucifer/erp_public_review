<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumptionDetailFabricItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumption_detail_fabric_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cons_sup');
            $table->integer('id_color');
            $table->float('total_qty');
            $table->string('komponen');
            $table->float('width');
            $table->string('w_unit');
            $table->float('kons_budget');
            $table->float('kons_marker');
            $table->float('kons_efi');
            $table->float('qty_unit');
            $table->float('tole');
            $table->float('qty_unit_tole');
            $table->float('qty_sample');
            $table->float('qty_purch');
            $table->float('budget_price');
            $table->float('supplier_price');
            $table->float('amount');
            $table->float('freight');
            $table->float('amount_freight');
            $table->string('unit');
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
        Schema::dropIfExists('consumption_detail_fabric_item');
    }
}
