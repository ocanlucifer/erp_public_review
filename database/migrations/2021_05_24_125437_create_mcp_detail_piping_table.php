<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcpDetailPipingTable extends Migration
{
    public function up()
    {
        Schema::create('mcp_detail_piping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mcp');
            $table->integer('id_mcpwsm');
            $table->integer('id_type');
            $table->string('untuk')->nullable();
            $table->float('ukuran')->nullable();
            $table->string('arah')->nullable();
            $table->integer('urutan');
            $table->string('kode_marker');
            $table->date('marker_date');
            $table->float('efisiensi')->nullable();
            $table->float('perimeter')->nullable();
            $table->float('tole_pjg_m')->nullable();
            $table->float('tole_lbr_m')->nullable();
            $table->string('pdf_marker')->nullable();
            $table->float('panjang_m')->nullable();
            $table->float('lebar_m')->nullable();
            $table->float('mp_pcs')->nullable();
            $table->string('pola_asli')->nullable();
            $table->float('gramasi')->nullable();
            $table->float('skala')->nullable();
            $table->float('jml_ampar')->nullable();
            $table->float('kons_sz_tgh')->nullable();
            $table->date('tgl_sz_tgh');
            $table->float('tot_ws_qty');
            $table->integer('tolerance')->nullable();
            $table->integer('revision')->nullable();
            $table->string('revision_remark')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mcp_detail_piping');
    }
}
