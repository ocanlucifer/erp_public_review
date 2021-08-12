<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkerproTable extends Migration
{
    public function up()
    {
        Schema::create('mp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('order_name');
            $table->string('fabric_const')->nullable();
            $table->string('fabric_comp')->nullable();
            $table->string('fabric_desc')->nullable();
            $table->string('style');
            $table->string('style_desc')->nullable();
            $table->date('delivery_date');
            $table->string('revision_count')->nullable();
            $table->string('revisi_remark')->nullable();
            $table->string('state');
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('confirmed_by');
        });

        Schema::create('mp_wsheet_main', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('no_urut');
            $table->string('combo');
            $table->integer('total_qty');
            $table->timestamps();
        });

        Schema::create('mp_wsheet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('mp_wsheet_m');
            $table->integer('no_urut');
            $table->string('combo');
            $table->string('size');
            $table->integer('ws_qty');
            $table->integer('tolerance');
            $table->integer('qty_tot');
            $table->timestamps();
        });

        Schema::create('mp_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('id_wsheet');
            $table->integer('no_urut');
            $table->string('type');
            $table->string('fabricconst')->nullable();
            $table->string('fabriccomp')->nullable();
            $table->string('fabricdesc')->nullable();
            $table->string('component');
            $table->string('warna');
            $table->string('tujuan')->nullable();
            $table->string('remark')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });

        Schema::create('mp_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('id_mpwsm');
            $table->integer('id_type');
            $table->integer('urutan');
            $table->string('code');
            $table->date('marker_date')->nullable();
            $table->float('efisiensi')->nullable();
            $table->float('perimeter')->nullable();
            $table->float('tole_pjg_m')->nullable();
            $table->float('tole_lbr_m')->nullable();
            $table->float('kons_sz_tgh');
            $table->date('tgl_sz_tgh');
            $table->float('panjang_m')->nullable();
            $table->float('lebar_m')->nullable();
            $table->float('gramasi')->nullable();
            $table->float('total_skala')->nullable();
            $table->float('jml_marker')->nullable();
            $table->float('jml_ampar')->nullable();
            $table->string('pdf_marker')->nullable();
            $table->string('komponen')->nullable();
            $table->integer('revisi')->nullable();
            $table->string('revisi_remark')->nullable();
            $table->timestamps();
        });

        Schema::create('mp_assort', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('id_mpwsm');
            $table->integer('id_ws');
            $table->integer('id_mpt');
            $table->integer('id_mpd');
            $table->string('size');
            $table->integer('qty_ws');
            $table->integer('scale');
            $table->timestamps();
        });

        Schema::create('mp_detail_piping', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mp');
            $table->integer('id_mpwsm');
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
        Schema::dropIfExists('mp');
        Schema::dropIfExists('mp_wsheet_main');
        Schema::dropIfExists('mp_wsheet');
        Schema::dropIfExists('mp_type');
        Schema::dropIfExists('mp_detail');
        Schema::dropIfExists('mp_assort');
        Schema::dropIfExists('mp_detail_piping');
    }
}
