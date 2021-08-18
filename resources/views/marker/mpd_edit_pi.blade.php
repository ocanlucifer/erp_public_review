@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/mp')}}">Production Marker</a></li>
        <li class="breadcrumb-item active"><a href="/mp/detail/{{$mp}}">Marker</a></li>
        <li class="breadcrumb-item active">Edit Production Marker</li>
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
                    <form action="{{route('mp.updatedetail_pi')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-content" id="modal-content" style="width: 100%;">
                            <div class="modal-header">
                                <h3>Edit Detail Piping</h3>
                            </div>

                            <input type="hidden" name="pi_id" id="pi_id" value="{{$mpi->id}}">
                            <input type="hidden" name="pi_mp" id="pi_mp" value="{{$mpi->mp}}">
                            <input type="hidden" name="pi_id_type" id="pi_id_type" value="{{$mpi->id_type}}">
                            <input type="hidden" name="pi_mpwsm_id" id="pi_mpwsm_id" value="{{$mpwsm_id}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Piping Untuk</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" id="pi_untuk"
                                            name="pi_untuk" value="{{$mpi->untuk}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_panjang_m" id="pi_panjang_m"
                                            value="{{$mpi->panjang_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Total WS Quantity</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_tot_ws_qty" id="pi_tot_ws_qty" value="{{$mpwsm->total_qty}}"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Ukuran (Cm)</b></small></div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" step="0.01" id="pi_ukuran"
                                            name="pi_ukuran" value="{{$mpi->ukuran}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                                    <div class="col-sm-4"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_lebar_m" id="pi_lebar_m" value="{{$mpi->lebar_m}}">
                                    </div>
                                    <div class="col-sm-4"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_lebar_inc" id="pi_lebar_inc"
                                            value="{{$mpi->lebar_m * 39.37}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Kg)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_be_kg" id="pi_qty_be_kg"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Arah</b></small></div>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="pi_arah" id="pi_arah">
                                            <option value="" disabled <?php if ($mpi->arah == "") {
                                                echo selected;} ?>>Select</option>
                                            <option value="diagonal" <?php if ($mpi->arah == "diagonal") {
                                                echo selected;} ?>>Diagonal</option>
                                            <option value="horizontal" <?php if ($mpi->arah == "horizontal") {
                                                echo selected;} ?>>Horizontal</option>
                                            <option value="vertikal" <?php if ($mpi->arah == "vertikal") {
                                                echo selected;} ?>>Vertikal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Meter per Pcs</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_mp_pcs" id="pi_mp_pcs" value="{{$mpi->mp_pcs}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Yd)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_be_yd" id="pi_qty_be_yd"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>*Marker ke</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" id="pi_urutan"
                                            name="pi_urutan" value="{{$mpi->urutan}}" required></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>Pola Asli</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" name="pi_pola_asli"
                                            id="pi_pola_asli" value="{{$mpi->pola_asli}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Mtr)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_be_mtr" id="pi_qty_be_mtr"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>*Kode Marker</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="text" name="pi_kode_marker"
                                            id="pi_kode_marker" value="{{$mpi->kode_marker}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_gramasi" id="pi_gramasi" value="{{$mpi->gramasi}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tolerance (%)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_tolerance" id="pi_tolerance"
                                            value="{{$mpi->tolerance}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"><small><b>*Marker Date</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="pi_marker_date"
                                            id="pi_marker_date" value="{{$mpi->marker_date}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Skala</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_skala" id="pi_skala" value="{{$mpi->skala}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty After Tole (Kg)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_af_kg" id="pi_qty_af_kg"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_efisiensi" id="pi_efisiensi" value="{{$mpi->efisiensi}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_jml_ampar" id="pi_jml_ampar"
                                            value="{{$mpi->jml_ampar}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty After Tole (Yd)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_af_yd" id="pi_qty_af_yd"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Perimeter (Cm)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_perimeter" id="pi_perimeter" value="{{$mpi->perimeter}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_kons_sz_tgh" id="pi_kons_sz_tgh" value="{{$mpi->kons_sz_tgh}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Qty After Tole (Mtr)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_qty_af_mtr" id="pi_qty_af_mtr"
                                            style="background-color: #FFB09F !important;" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_tole_pjg_m" id="pi_tole_pjg_m"
                                            value="{{$mpi->tole_pjg_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>*Tgl Sz Tgh</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="date" name="pi_tgl_sz_tgh"
                                            id="pi_tgl_sz_tgh" value="{{$mpi->tgl_sz_tgh}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revision</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" name="pi_revision"
                                            id="pi_revision" value="{{$mpi->revision}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control form-detail-pi" type="number"
                                            step="0.01" name="pi_tole_lbr_m" id="pi_tole_lbr_m"
                                            value="{{$mpi->tole_lbr_m}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons (Kg/Dz)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_kons_kgdz" id="pi_kons_kgdz" value="{{$mpi->kons_kgdz}}" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Revision Remark</b></small></div>
                                    <div class="col-sm-8"><textarea class="form-control" type="text"
                                            name="pi_revision_remark"
                                            id="pi_revision_remark">{{$mpi->revision_remark}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="pdf_marker_name"
                                            id="pdf_marker_name" value="{{$mpi->pdf_marker}}">
                                        <input class="form-control" type="file" name="pi_pdf_marker" id="pi_pdf_marker">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons (Yd/Dz)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_kons_yddz" d id="pi_kons_yddz" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-lg-1"></div>
                                <div class="col-sm-4 mt-lg-1"></div>
                                <div class="col-sm-4 mt-lg-1">
                                    <div class="col-sm-4 text-right"><small><b>Kons (M/Dz)</b></small></div>
                                    <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                            name="pi_kons_mdz" id="pi_kons_mdz" readonly
                                            style="background-color: #FFB09F !important;">
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-20 mb-20">
                                    <input type="submit" id="submit_detail" name="submit_detail"
                                        class="btn btn-primary mr-20 float-right" value="Update">
                                    <a href="/mp/detail/{{$mp}}" class="float-right mr-20 mt-10">Kembali</a>
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
            firstPage();
            $(".form-detail-pi").keyup(function(){
                // Perhitungan Lebar (m) to (inc)
                var lebar = document.getElementById('pi_lebar_m').value;
                var lebar_inc = lebar * 39.37;
                document.getElementById('pi_lebar_inc').value = Math.round(lebar_inc * 100)/100;

                // Perhitungan Quantity
                val_fabric_yard = 0;
                val_fabric_kg = 0;
                val_fabric_meter = 0;
                val_before_tolerance_kg = 0;
                val_before_tolerance_yard = 0;
                val_before_tolerance_meter = 0;

                val_length = parseFloat($("#pi_panjang_m").val());
                val_width = parseFloat($("#pi_lebar_m").val());
                val_length_tole = parseFloat($("#pi_tole_pjg_m").val());
                val_width_tole = parseFloat($("#pi_tole_lbr_m").val());
                val_gramasi = parseFloat($("#pi_gramasi").val());
                val_scale = parseFloat($("#pi_skala").val());
                val_ws_quantity = parseFloat($("#pi_tot_ws_qty").val());
                val_tolerance = parseFloat($("#pi_tolerance").val());

                // Consumption before tolerance
                val_fabric_kg = ((((val_length + val_length_tole) * (val_width + val_width_tole) * val_gramasi) / val_scale) * 12) /
                1000;
                val_fabric_yard = (((val_length + val_length_tole) / val_scale ) / 0.914) * 12;
                val_fabric_meter = ((val_length + val_length_tole) / val_scale) * 12

                if (isNaN(val_fabric_kg) == true || val_scale == 0)
                val_fabric_kg = 0;

                if (isNaN(val_fabric_yard) == true || val_scale == 0)
                val_fabric_yard = 0;

                if (isNaN(val_fabric_meter) == true || val_scale == 0)
                val_fabric_meter = 0;

                $("#pi_kons_kgdz").val(val_fabric_kg.toFixed(2));
                $("#pi_kons_yddz").val(val_fabric_yard.toFixed(2));
                $("#pi_kons_mdz").val(val_fabric_meter.toFixed(2));

                val_before_tolerance_kg = (val_fabric_kg.toFixed(2) * val_ws_quantity) / 12;
                val_before_tolerance_yard = (val_fabric_yard.toFixed(2) * val_ws_quantity) / 12;
                val_before_tolerance_meter = (val_fabric_meter.toFixed(2) * val_ws_quantity) / 12;

                $("#pi_qty_be_kg").val(val_before_tolerance_kg.toFixed(2));
                $("#pi_qty_be_yd").val(val_before_tolerance_yard.toFixed(2));
                $("#pi_qty_be_mdz").val(val_before_tolerance_meter.toFixed(2));

                val_after_tolerance_kg = val_before_tolerance_kg + (val_before_tolerance_kg * val_tolerance / 100);
                val_after_tolerance_yard = val_before_tolerance_yard + (val_before_tolerance_yard * val_tolerance / 100);
                val_after_tolerance_meter = val_before_tolerance_meter + (val_before_tolerance_meter * val_tolerance / 100);

                $("#pi_qty_af_kg").val(val_after_tolerance_kg.toFixed(2));
                $("#pi_qty_af_yd").val(val_after_tolerance_yard.toFixed(2));
                $("#pi_qty_af_mtr").val(val_after_tolerance_meter.toFixed(2));
            });
        });

        function firstPage()
        {
            // Perhitungan Lebar (m) to (inc)
            var lebar = document.getElementById('pi_lebar_m').value;
            var lebar_inc = lebar * 39.37;
            document.getElementById('pi_lebar_inc').value = Math.round(lebar_inc * 100)/100;

            // Perhitungan Quantity
            val_fabric_yard = 0;
            val_fabric_kg = 0;
            val_fabric_meter = 0;
            val_before_tolerance_kg = 0;
            val_before_tolerance_yard = 0;
            val_before_tolerance_meter = 0;

            val_length = parseFloat($("#pi_panjang_m").val());
            val_width = parseFloat($("#pi_lebar_m").val());
            val_length_tole = parseFloat($("#pi_tole_pjg_m").val());
            val_width_tole = parseFloat($("#pi_tole_lbr_m").val());
            val_gramasi = parseFloat($("#pi_gramasi").val());
            val_scale = parseFloat($("#pi_skala").val());
            val_ws_quantity = parseFloat($("#pi_tot_ws_qty").val());
            val_tolerance = parseFloat($("#pi_tolerance").val());

            // Consumption before tolerance
            val_fabric_kg = ((((val_length + val_length_tole) * (val_width + val_width_tole) * val_gramasi) / val_scale) * 12) /1000;
            val_fabric_yard = (((val_length + val_length_tole) / val_scale ) / 0.914) * 12;
            val_fabric_meter = ((val_length + val_length_tole) / val_scale) * 12

            if (isNaN(val_fabric_kg) == true || val_scale == 0)
            val_fabric_kg = 0;

            if (isNaN(val_fabric_yard) == true || val_scale == 0)
            val_fabric_yard = 0;

            if (isNaN(val_fabric_meter) == true || val_scale == 0)
            val_fabric_meter = 0;

            $("#pi_kons_kgdz").val(val_fabric_kg.toFixed(2));
            $("#pi_kons_yddz").val(val_fabric_yard.toFixed(2));
            $("#pi_kons_mdz").val(val_fabric_meter.toFixed(2));

            // Quantity before Tolerance
            val_before_tolerance_kg = (val_fabric_kg.toFixed(2) * val_ws_quantity) / 12;
            val_before_tolerance_yard = (val_fabric_yard.toFixed(2) * val_ws_quantity) / 12;
            val_before_tolerance_meter = (val_fabric_meter.toFixed(2) * val_ws_quantity) / 12;

            $("#pi_qty_be_kg").val(val_before_tolerance_kg.toFixed(2));
            $("#pi_qty_be_yd").val(val_before_tolerance_yard.toFixed(2));
            $("#pi_qty_be_mtr").val(val_before_tolerance_meter.toFixed(2));

            // Quantity after Tolerance
            val_after_tolerance_kg = val_before_tolerance_kg + (val_before_tolerance_kg * val_tolerance / 100);
            val_after_tolerance_yard = val_before_tolerance_yard + (val_before_tolerance_yard * val_tolerance / 100);
            val_after_tolerance_meter = val_before_tolerance_meter + (val_before_tolerance_meter * val_tolerance / 100);

            $("#pi_qty_af_kg").val(val_after_tolerance_kg.toFixed(2));
            $("#pi_qty_af_yd").val(val_after_tolerance_yard.toFixed(2));
            $("#pi_qty_af_mtr").val(val_after_tolerance_meter.toFixed(2));
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
