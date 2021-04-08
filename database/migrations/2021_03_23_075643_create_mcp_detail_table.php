<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcpDetailTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mcp');
            $table->integer('id_type');
            $table->integer('urutan');
            $table->string('code');
            $table->date('marker_date');
            $table->float('efisiensi');
            $table->float('perimeter');
            $table->string('designer');
            $table->float('tole_pjg_m');
            $table->float('tole_lbr_m');
            $table->float('kons_sz_tgh');
            $table->date('tgl_sz_tgh');
            $table->float('panjang_m');
            $table->float('lebar_m');
            $table->float('gramasi');
            $table->float('total_skala');
            // $table->float('kons_yddz');
            // $table->float('kons_kgdz');
            // $table->float('kons_mdz');
            $table->float('jml_marker');
            $table->float('jml_ampar');
            $table->string('pdf_marker');
            // $table->float('qty_yard');
            // $table->float('qty_kg');
            // $table->float('qty_m');
            // $table->float('ujungkain_yd');
            // $table->float('ujungkain_kg');
            // $table->float('ujungkain_m');
            $table->string('komponen');
            $table->integer('revisi');
            $table->string('revisi_remark');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_detail');
    }
}
