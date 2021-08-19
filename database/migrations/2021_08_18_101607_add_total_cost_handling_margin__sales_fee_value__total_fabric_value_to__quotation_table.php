<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalCostHandlingMarginSalesFeeValueTotalFabricValueToQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->float('sales_fee_value')->nullable()->after('sales_fee');
            $table->float('totalcost_handling_margin')->nullable()->after('margin');
            $table->float('total_fabric_value')->nullable()->after('rate');
        });

    }

    public function down()
    {
        //
    }
}