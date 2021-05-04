@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/salesorders')}}">Marker Check Production</a></li>
        <li class="breadcrumb-item active">Edit MCP</li>
    </ol>

    @if ($sukses = Session::get('sukses'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $sukses; ?>
    </div>
    @endif
    @if ($error = Session::get('error'))
    <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $error; ?>
    </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="card-body">
                    <form action="{{route('mcp.updatedetail')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-content" id="modal-content" style="width: 100%;">
                            <div class="modal-header">
                                <h3>MCP Detail</h3>
                                <div class="float-right">
                                    <a href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp}}/{{$qty_d}}/{{$size_d}}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <a href="/mcp/detail/{{$mcp}}" class="btn btn-sm btn-primary">Kembali</a>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="id" value="{{$mcpd->id}}">
                            <input type="hidden" name="mcp" id="mcp" value="{{$mcpd->mcp}}">
                            <input type="hidden" name="id_type" id="id_type" value="{{$mcpd->id_type}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Marker ke</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" id="urutan"
                                            name="urutan" value="{{$mcpd->urutan}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                                    <div class="col-sm-4"><input class="form-control" type="number" step="0.01"
                                            name="lebar_m" id="lebar_m" value="{{$mcpd->lebar_m}}" readonly>
                                    </div>
                                    <div class="col-sm-4"><input class="form-control" type="number" step="0.01"
                                            name="lebar_inc" id="lebar_inc" value="{{$mcpd->lebar_inc}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (yard)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_yard" id="qty_yard" value="{{$mcpd->qty_yard}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>*Code</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" name="code" id="code"
                                            value="{{$mcpd->code}}" required readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="gramasi" id="gramasi" value="{{$mcpd->gramasi}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (kg)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_kg" id="qty_kg" value="{{$mcpd->qty_kg}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Marker Date</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="marker_date"
                                            id="marker_date" value="{{$mcpd->marker_date}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Total Skala</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="total_skala" id="total_skala" value="{{$mcpd->total_skala}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_m" id="qty_m" value="{{$mcpd->qty_m}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="efisiensi" id="efisiensi" value="{{$mcpd->efisiensi}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain Yd/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_yddz" d id="kons_yddz" value="{{$mcpd->kons_yddz}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Ujiung Kain Yd</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="ujungkain_yd" id="ujungkain_yd" value="{{$mcpd->ujungkain_yd}}"
                                            readonly readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Perimeter</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="perimeter" id="perimeter" value="{{$mcpd->perimeter}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain Kg/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_kgdz" d id="kons_kgdz" value="{{$mcpd->kons_kgdz}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Ujiung Kain Kg</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="ujungkain_kg" id="ujungkain_kg" value="{{$mcpd->ujungkain_kg}}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>*Designer</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" name="designer" id="designer"
                                            value="{{$mcpd->designer}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain m/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_mdz" id="kons_mdz" value="{{$mcpd->kons_mdz}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Ujiung Kain Mtr</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="ujungkain_m" id="ujungkain_m" value="{{$mcpd->ujungkain_m}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="tole_pjg_m" id="tole_pjg_m" value="{{$mcpd->tole_pjg_m}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Jumlah Marker</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="jml_marker" id="jml_marker" value="{{$mcpd->jml_marker}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Komponen / Pcs</b></small></div>
                                    <div class="col-sm-8"><textarea class="form-control" type="text" name="komponen"
                                            id="komponen" value="{{$mcpd->komponen}}" readonly></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="tole_lbr_m" id="tole_lbr_m" value="{{$mcpd->tole_lbr_m}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="jml_ampar" id="jml_ampar" value="{{$mcpd->jml_ampar}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revisi</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" name="revisi"
                                            id="revisi" value="{{$mcpd->revisi}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_sz_tgh" id="kons_sz_tgh" value="{{$mcpd->kons_sz_tgh}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="pdf_marker_name"
                                            id="pdf_marker_name" value="{{$mcpd->pdf_marker}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revisi Remark</b></small></div>
                                    <div class="col-sm-8"><textarea class="form-control" type="text"
                                            name="revisi_remark" id="revisi_remark"
                                            readonly>{{$mcpd->revisi_remark}}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tgl Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="tgl_sz_tgh"
                                            id="tgl_sz_tgh" value="{{$mcpd->tgl_sz_tgh}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="panjang_m" id="panjang_m" value="{{$mcpd->panjang_m}}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-lg-1">
                                    <div class="row mt-10">
                                        <div class="col-sm-4">
                                            {{-- <input type="submit" id="submit_detail" name="submit_detail"
                                                class="btn btn-primary ml-10">
                                            <div class="col-sm-4">
                                            </div> --}}
                                            {{-- <a href="/mcp/detail/{{$mcp}}" class="btn btn-sm
                                            btn-primary">Kembali</a> --}}
                                            {{-- <button class="btn btn-sm btn-warning" type="button"
                                                                            id="ws_calculate">Calculate</button> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-lg-5">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Qty Ws</th>
                                                    <th>Scale</th>
                                                    <th>Scales</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-detail">
                                                <tr>
                                                    <td><input type="text" class="form-control" name="detail_size"
                                                            id="detail_size" value="{{$size_d}}" readonly>
                                                    </td>
                                                    <td><input type="text" class="form-control" name="detail_qty"
                                                            id="detail_qty" value="{{$qty_d}}" readonly>
                                                    </td>
                                                    <td><input type="text" class="form-control" name="detail_scale"
                                                            id="detail_scale" readonly></td>
                                                    <td><input type="text" class="form-control" name="detail_scales"
                                                            id="detail_scales" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
                var panjang = document.getElementById('panjang_m').value;
                var tole_panjang = document.getElementById('tole_pjg_m').value;
                var lebar = document.getElementById('lebar_m').value;
                var tole_lebar = document.getElementById('tole_lbr_m').value;
                var gramasi = document.getElementById('gramasi').value;
                var skala = document.getElementById('total_skala').value;
                var jml_ampar = document.getElementById('jml_ampar').value;
                var detail_scale = document.getElementById('total_skala').value;
                // Perhitungan Lebar (m) to (inc)
                var lebar_inc=lebar * 39.37;
                document.getElementById('lebar_inc').value = Math.round(lebar_inc * 100)/100;

                // Perhitungan Konsumsi Kg/Dz=(Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
                var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
                console.log('kons_kgdz=' + kons_kgdz);
                document.getElementById('kons_kgdz').value = Math.round(kons_kgdz * 100)/100;

                // Perhitungan Konsumsi Yard/Dz=(Panjang + toleransi) / 0.914 / Skala x 12
                var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12; console.log('kons_yddz=' + kons_yddz);
                document.getElementById('kons_yddz').value = Math.round(kons_yddz * 100)/100;

                // Perhitungan Konsumsi Meter/Dz=(Panjang + toleransi) / Skala x 12
                var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala *12; console.log('kons_mdz=' + kons_mdz);
                document.getElementById('kons_mdz').value = Math.round(kons_mdz * 100)/100;

                // isi input scale=total_skala
                document.getElementById('detail_scale').value = detail_scale; // isi input scales=scale * jumlah ampar var

                detail_scales =detail_scale * jml_ampar;
                document.getElementById('detail_scales').value = detail_scales;

                // Perhitungan Qty per Yard, Kg dan meter=Jumlah Ampar x Total Skala x Konsumsi / 12
                var qty_yard = jml_ampar * detail_scale * kons_yddz / 12; var qty_kg=jml_ampar * detail_scale * kons_kgdz / 12;
                var qty_m = jml_ampar * detail_scale * kons_mdz / 12;

                document.getElementById('qty_yard').value = Math.round(qty_yard * 100)/100;
                document.getElementById('qty_kg').value = Math.round(qty_kg * 100)/100;
                document.getElementById('qty_m').value = Math.round(qty_m * 100)/100;
        });
    </script>

    <script type="text/javascript">
        $(window).on('hashchange', function() {
		if (window.location.hash) {
			var page = window.location.hash.replace('#', '');
			if (page == Number.NaN || page <= 0) {
				return false;
			} else {
				getDatas(page);
			}
		}
	});

	$(document).ready(function() {
		$(document).on('click', '.pagination a', function (e) {
			// $('tbody').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../public/images/loading.gif" />');
			var url = $(this).attr('href');
			getDatas($(this).attr('href').split('page=')[1]);
			e.preventDefault();
		});
    });

    </script>
