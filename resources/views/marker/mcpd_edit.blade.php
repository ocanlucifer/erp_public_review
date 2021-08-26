@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/mcp')}}">Marker Check Production</a></li>
        <li class="breadcrumb-item active"><a href="/mcp/detail/{{$mcp}}">Marker</a></li>
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
                    <form action="{{route('mcp.updatedetail_ma')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-content" id="modal-content" style="width: 100%;">
                            <div class="modal-header">
                                <h3>Edit Detail</h3>
                            </div>

                            <input type="hidden" name="id" id="id" value="{{$mcpd->id}}">
                            <input type="hidden" name="mcp" id="mcp" value="{{$mcpd->mcp}}">
                            <input type="hidden" name="id_type" id="id_type" value="{{$mcpd->id_type}}">
                            <input type="hidden" name="mcpwsm_id" id="mcpwsm_id" value="{{$mcpwsm_id}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Marker ke</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" id="urutan"
                                            name="urutan" value="{{$mcpd->urutan}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="panjang_m" id="panjang_m" value="{{$mcpd->panjang_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Total Skala</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="total_skala" id="total_skala" value="{{$mcpd->total_skala}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>*Code</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" name="code" id="code"
                                            value="{{$mcpd->code}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                                    <div class="col-sm-4"><input class="form-control" type="number" step="0.01"
                                            name="lebar_m" id="lebar_m" value="{{$mcpd->lebar_m}}">
                                    </div>
                                    <div class="col-sm-4"><input class="form-control" type="number" step="0.01"
                                            name="lebar_inc" id="lebar_inc" value="{{$mcpd->lebar_inc}}"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain Yd/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_yddz" d id="kons_yddz" value="{{$mcpd->kons_yddz}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Marker Date</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="marker_date"
                                            id="marker_date" value="{{$mcpd->marker_date}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="tole_pjg_m" id="tole_pjg_m" value="{{$mcpd->tole_pjg_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain Kg/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_kgdz" d id="kons_kgdz" value="{{$mcpd->kons_kgdz}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="efisiensi" id="efisiensi" value="{{$mcpd->efisiensi}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="tole_lbr_m" id="tole_lbr_m" value="{{$mcpd->tole_lbr_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Kain m/Dz</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_mdz" id="kons_mdz" value="{{$mcpd->kons_mdz}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Perimeter</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="perimeter" id="perimeter" value="{{$mcpd->perimeter}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="gramasi" id="gramasi" value="{{$mcpd->gramasi}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (yard)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_yard" id="qty_yard" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="kons_sz_tgh" id="kons_sz_tgh" value="{{$mcpd->kons_sz_tgh}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="jml_ampar" id="jml_ampar" value="{{$mcpd->jml_ampar}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (kg)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_kg" id="qty_kg" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tgl Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="tgl_sz_tgh"
                                            id="tgl_sz_tgh" value="{{$mcpd->tgl_sz_tgh}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Jumlah Marker</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="jml_marker" id="jml_marker" value="{{$mcpd->jml_marker}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                            name="qty_m" id="qty_m" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Komponen / Pcs</b></small></div>
                                    <div class="col-sm-8"><textarea class="form-control" type="text" name="komponen"
                                            id="komponen">{{$mcpd->komponen}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="pdf_marker_name"
                                            id="pdf_marker_name" value="{{$mcpd->pdf_marker}}">
                                        <input class="form-control" type="file" name="pdf_marker" id="pdf_marker">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revisi</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" name="revisi"
                                            id="revisi" value="{{$mcpd->revisi}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revisi Remark</b></small></div>
                                    <div class="col-sm-8"><textarea class="form-control" type="text"
                                            name="revisi_remark" id="revisi_remark">{{$mcpd->revisi_remark}}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-10">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Qty Ws</th>
                                                    <th>Scale</th>
                                                    <th>Scales</th>
                                                </tr>
                                            </thead>
                                            <tbody id="detail-ass-tbody">
                                                {{-- --------------------Assort-------------------- --}}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-20 mb-20">
                                    <input type="submit" id="submit_detail" name="submit_detail"
                                        class="btn btn-primary mr-20 float-right" value="Update">
                                    <a href="/mcp/detail/{{$mcp}}" class="float-right mr-20 mt-10">Kembali</a>
                                    <a href="#" class="btn btn-sm btn-warning float-right mr-20"
                                        onclick="assort_cal()">Calculate</a>
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

            detail_cal();

            var mcpd_id = $('input[name="id"]').val();
            // var mcpwsmid = $('input[name="mcpwsm_id"]').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url:"/mcp/geteditsize",
                method:"POST",
                data:{mcpd_id:mcpd_id, _token:_token},
                success:function(data){
                    console.log(data);

                    var i;
                    var jml_ampar = document.getElementById("jml_ampar").value;
                    for(i=0; i<data.length; i++){
                        baris = '<tr>' +
                            '<input class="form-control form-detail" type="hidden" name="input_id_mcpa[]" id="input_id_mcpa'+i+'" value="'+data[i].id+'" readonly>'+
                            '<td>' +'<input class="form-control form-detail" type="text" name="input_det_size[]" id="input_det_size_'+i+'"'+' style="background-color: #FFB09F !important;"'+'" value="'+data[i].size+'" readonly>'+'</td>'+
                            '<td>'+'<input class="form-control form-detail" type="number" name="input_det_qty[]" id="input_det_qty_'+i+'"'+' style="background-color: #FFB09F !important;"'+'" value="'+data[i].qty_ws+'" readonly>'+'</td>'+
                            '<td>'+'<input class="form-control form-detail" type="number" name="input_det_scale[]" id="input_det_scale_'+i+'" value="'+data[i].scale+'">'+'</td>'+
                            '<td>'+'<input class="form-control form-detail" type="number" name="input_det_scales[]" id="input_det_scales_'+i+'"'+' style="background-color: #FFB09F !important;"'+' value="'+jml_ampar * data[i].scale+'" readonly>'+'</td>'+
                            '</tr>'
                        $('#detail-ass-tbody').append(baris);
                    }
                    baris2 = '<input type="hidden" name="index_assort" id="index_assort" value="'+i+'">'
                    $('#detail-ass-tbody').append(baris2);
                }
            });

                // var id_mcpt = $(this).data("mcptid");
                // $("#id_type").val(id_mcpt);

            $("input").keyup(function(){
                    var panjang = document.getElementById('panjang_m').value;
                    var tole_panjang = document.getElementById('tole_pjg_m').value;
                    var lebar = document.getElementById('lebar_m').value;
                    var tole_lebar = document.getElementById('tole_lbr_m').value;
                    var gramasi = document.getElementById('gramasi').value;
                    var skala = document.getElementById('total_skala').value;
                    var jml_ampar = document.getElementById('jml_ampar').value;
                    // var detail_scale = document.getElementById('total_skala').value;

                    // Perhitungan Lebar (m) to (inc)
                    var lebar_inc=lebar * 39.37;
                    document.getElementById('lebar_inc').value = Math.round(lebar_inc * 100)/100;

                    // Perhitungan Konsumsi Kg/Dz=(Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
                    var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
                    document.getElementById('kons_kgdz').value = Math.round(kons_kgdz * 100)/100;

                    // Perhitungan Konsumsi Yard/Dz=(Panjang + toleransi) / 0.914 / Skala x 12
                    var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
                    document.getElementById('kons_yddz').value = Math.round(kons_yddz * 100)/100;

                    // Perhitungan Konsumsi Meter/Dz=(Panjang + toleransi) / Skala x 12
                    var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala *12;
                    document.getElementById('kons_mdz').value = Math.round(kons_mdz * 100)/100;

                    // Perhitungan Qty per Yard, Kg dan meter=Jumlah Ampar x Total Skala x Konsumsi / 12
                    var qty_yard = jml_ampar * skala * kons_yddz / 12;
                    var qty_kg = jml_ampar * skala * kons_kgdz / 12;
                    var qty_m = jml_ampar * skala * kons_mdz / 12;

                    document.getElementById('qty_yard').value = Math.round(qty_yard * 100)/100;
                    document.getElementById('qty_kg').value = Math.round(qty_kg * 100)/100;
                    document.getElementById('qty_m').value = Math.round(qty_m * 100)/100;
            });
        });

        function detail_cal(){
            var panjang = document.getElementById('panjang_m').value;
            var tole_panjang = document.getElementById('tole_pjg_m').value;
            var lebar = document.getElementById('lebar_m').value;
            var tole_lebar = document.getElementById('tole_lbr_m').value;
            var gramasi = document.getElementById('gramasi').value;
            var skala = document.getElementById('total_skala').value;
            var jml_ampar = document.getElementById('jml_ampar').value;
            // var detail_scale = document.getElementById('total_skala').value;

            // Perhitungan Lebar (m) to (inc)
            var lebar_inc=lebar * 39.37;
            document.getElementById('lebar_inc').value = Math.round(lebar_inc * 100)/100;

            // Perhitungan Konsumsi Kg/Dz=(Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
            var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) *
            (gramasi/1000) / skala * 12;
            document.getElementById('kons_kgdz').value = Math.round(kons_kgdz * 100)/100;

            // Perhitungan Konsumsi Yard/Dz=(Panjang + toleransi) / 0.914 / Skala x 12
            var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
            document.getElementById('kons_yddz').value = Math.round(kons_yddz * 100)/100;

            // Perhitungan Konsumsi Meter/Dz=(Panjang + toleransi) / Skala x 12
            var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala *12;
            document.getElementById('kons_mdz').value = Math.round(kons_mdz * 100)/100;

            // Perhitungan Qty per Yard, Kg dan meter=Jumlah Ampar x Total Skala x Konsumsi / 12
            var qty_yard = jml_ampar * skala * kons_yddz / 12;
            var qty_kg = jml_ampar * skala * kons_kgdz / 12;
            var qty_m = jml_ampar * skala * kons_mdz / 12;

            document.getElementById('qty_yard').value = Math.round(qty_yard * 100)/100;
            document.getElementById('qty_kg').value = Math.round(qty_kg * 100)/100;
            document.getElementById('qty_m').value = Math.round(qty_m * 100)/100;
        }

        function assort_cal(){
            // mendapatkan total skala secara otomatis
            var index_assort = document.getElementById('index_assort').value;
            var jml_ampar = document.getElementById("jml_ampar").value;
            var jml_marker = document.getElementById("jml_marker").value;
            var tot_ass_scale = 0;

            for(i = 0; i < index_assort; i++){
                var ass_scale = document.getElementById("input_det_scale_"+i).value;
                var ass_scales = jml_ampar * jml_marker * ass_scale;
                document.getElementById("input_det_scales_"+i).value=ass_scales;
                tot_ass_scale += parseInt(ass_scale);
            }
            document.getElementById("total_skala").value=tot_ass_scale;
        }
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
