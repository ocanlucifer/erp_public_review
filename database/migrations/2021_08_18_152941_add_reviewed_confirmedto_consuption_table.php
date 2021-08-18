<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewedConfirmedtoConsuptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consumptions', function (Blueprint $table) {
            $table->bigInteger('reviewed_by')->nullable()->after('updated_by');
            $table->bigInteger('confirmed_by')->nullable()->after('reviewed_by');
            $table->datetime('reviewed_at')->nullable()->after('updated_at');
            $table->datetime('confirmed_at')->nullable()->after('reviewed_at');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
