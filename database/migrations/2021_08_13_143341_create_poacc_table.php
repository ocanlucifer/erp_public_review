<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoaccTable extends Migration
{
    public function up()
    {
        Schema::create('po_acc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('supplier')->nullable();
            $table->string('currency');
            $table->float('exchange_rate');
            $table->date('order_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('price_term');
            $table->string('payment_term');
            $table->string('bank_charges')->nullable();
            $table->text('note')->nullable();
            $table->float('rounding_value')->nullable();
            $table->float('allowance_qty')->nullable();
            $table->string('state');
            $table->integer('printed_count');
            $table->string('created_by');
            $table->string('updated_by')->nullable();
            $table->string('reviewed_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('poacc');
    }
}
