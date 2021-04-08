<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->string('code', 30)->primary();
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->integer('top')->nullable();
            $table->double('ppn', 15, 3)->nullable();
            $table->string('email')->nullable();
            $table->string('npwp')->nullable();
            $table->string('bank')->nullable();
            $table->string('rekening')->nullable();
            $table->string('currency', 30)->nullable();
            $table->double('exchange_rate', 15, 3)->nullable();
            $table->string('price_term')->nullable();
            $table->string('payment_term')->nullable();
            $table->text('remarks')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('supplier');
    }
}
