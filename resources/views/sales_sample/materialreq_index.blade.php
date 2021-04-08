@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salessamples') }}">Master Sales Sample</a></li>
        <li class="breadcrumb-item active">Material Requirements</a></li>
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

    <?php $id_sales_sample = Request::segment(3); ?>
    <input type="hidden" name="idsalessample" id="idsalessample" value="{{$id_sales_sample}}">

    <div class="row">
        <div class="col-lg-12">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="/assortment/{{$id_sales_sample}}">Assortment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salessamples/sizespecs/{{$id_sales_sample}}">Size Specs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salessamples/remark/{{$id_sales_sample}}">Remark</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"
                            href="/salessamples/materialrequirements/{{$id_sales_sample}}">Material
                            Requirements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salessamples/image/{{$id_sales_sample}}">Images</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Material Requirements
        </div>
        <div class="card-body">
            {{-- <div align="right"> --}}
            <div class="row">
                <div class="col-md-2">
                    <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;"
                        placeholder="Search Number" id="keyword" autocomplete="off">
                </div>
                <div class="col-md-8"></div>
                <div class="col-md-2">
                    <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i
                            class="icon-pencil"></i>
                        Add Material Requirements</a>
                </div>
            </div>
            {{-- </div> --}}
            <br>

            <table class="table table-bordered table-responsive text-center">

                <thead>
                    <tr class="card-header">
                        <th>No.</th>
                        <th>Number</th>
                        <th>Fabric Construct</th>
                        <th>Fabric Compost</th>
                        <th>Fabric Description</th>
                        <th>Budget</th>
                        <th>PO Status</th>
                        <th>State</th>
                        <th>Purchasing</th>
                        <th>Note</th>
                        <th>
                            <center>#</center>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody_main">
                    @include('sales_sample.materialreq_list')
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="align">
                        <h5 class="font-weight-bold" id="set_number_detail">Number :</h5>
                    </div>
                </div>
                <div class="col-md-6">
                    <div align="right">
                        <a href="#modal-detail" data-toggle="modal" class="btn btn-primary disabled"
                            onclick="submit('tambah')" id="btn-modal-detail"><i class="icon-pencil"></i>
                            Add Material Detail</a>
                    </div>
                </div>
            </div>
            <br>

            <table class="table table-bordered table-striped table-hover table-responsive text-center"
                id="tabel_detail">

                <thead>
                    <tr class="card-header">
                        <th>No.</th>
                        <th>GMT Color</th>
                        <th>GMT Size</th>
                        <th>MAT Color</th>
                        <th>MAT Size</th>
                        <th>Qty</th>
                        <th>Cons</th>
                        <th>Per GM</th>
                        <th>Wastag</th>
                        <th>Total Req</th>
                        <th>Unit</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Purchasing Order</th>
                        <th>
                            <center>#</center>
                        </th>
                    </tr>
                </thead>
                <tbody id="tbody_detail"></tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/salessamples/materialrequirements/new/{{$id_sales_sample}}" method="post"
                    enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Material Requirements</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id_sales_sample" id="id_sales_sample"
                                    value="{{$id_sales_sample}}">
                                <div class="input-group">
                                    <label for="fabric_construct">Fabric Construct</label>
                                    <input type="hidden" id="id_fabric_construct" type="text"
                                        class="form-control @error('id_fabric_construct') is-invalid @enderror"
                                        name="id_fabric_construct" value="{{ old('id_fabric_construct') }}" required
                                        autocomplete="off">
                                    <input id="fabric_construct" type="text"
                                        class="form-control @error('fabric_construct') is-invalid @enderror"
                                        name="fabric_construct" value="{{ old('fabric_construct') }}" required
                                        autocomplete="off">
                                    <span>
                                        <div id="id_fabric_constructlist"></div>
                                    </span>

                                    @error('id_fabric_construct')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabric_compost">Fabric Compost</label>
                                    <input type="hidden" id="id_fabric_compost" type="text"
                                        class="form-control @error('id_fabric_compost') is-invalid @enderror"
                                        name="id_fabric_compost" value="{{ old('id_fabric_compost') }}" required
                                        autocomplete="off">
                                    <input id="fabric_compost" type="text"
                                        class="form-control @error('fabric_compost') is-invalid @enderror"
                                        name="fabric_compost" value="{{ old('fabric_compost') }}" required
                                        autocomplete="off">
                                    <span>
                                        <div id="id_fabric_compostlist"></div>
                                    </span>

                                    @error('id_fabric_compost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabric_description">Fabric Descripstion</label>
                                    <input type="text" name="fabric_description" id="fabric_description"
                                        class="form-control" placeholder="Fabric Description">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="budget">Budget</label>
                                    <input type="number" name="budget" id="budget" class="form-control"
                                        placeholder="Budget" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="po_status">PO Status</label>
                                    <select class="form-control" name="po_status" id="po_status">
                                        <option value="false">False</option>
                                        <option value="true">True</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detail" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Data Bahan</h3>
                </div>

                <center>
                    <font color="red">
                        <p id="pesan"></p>
                    </font>
                </center>

                <table class="table text-center">
                    <input type="hidden" name="id2" id="id2" value="">
                    <input type="hidden" name="id_sales_sample2" id="id_sales_sample2" value="">
                    <input type="hidden" name="id_material_req2" id="id_material_req2" value="">

                    <tr>
                        <td>GMT Color</td>
                        <td>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" id="id_gmt_color" type="text"
                                        class="form-control @error('id_gmt_color') is-invalid @enderror"
                                        name="id_gmt_color" value="{{ old('id_gmt_color') }}" required
                                        autocomplete="off">
                                    <input id="gmt_color" type="text"
                                        class="form-control @error('gmt_color') is-invalid @enderror" name="gmt_color"
                                        value="{{ old('gmt_color') }}" required autocomplete="off"
                                        placeholder="pilih GMT Color">
                                    <span>
                                        <div id="id_gmt_colorlist"></div>
                                    </span>

                                    @error('id_gmt_color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>GMT Size</td>
                        <td>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" id="id_gmt_size" type="text"
                                        class="form-control @error('id_gmt_size') is-invalid @enderror"
                                        name="id_gmt_size" value="{{ old('id_gmt_size') }}" required autocomplete="off">
                                    <input id="gmt_size" type="text"
                                        class="form-control @error('gmt_size') is-invalid @enderror" name="gmt_size"
                                        value="{{ old('gmt_size') }}" required autocomplete="off"
                                        placeholder="pilih GMT Size">
                                    <span>
                                        <div id="id_gmt_sizelist"></div>
                                    </span>

                                    @error('id_gmt_size')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>MAT Color</td>
                        <td><input type="text" name="mat_color" placeholder="MAT Color" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>MAT Size</td>
                        <td><input type="text" name="mat_size" placeholder="MAT Size" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td><input type="number" name="quantity" placeholder="Quantity" class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Consumption</td>
                        <td><input type="number" name="consumption" placeholder="Consumption" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Per Garment</td>
                        <td><input type="number" name="per_garment" placeholder="Per Garment" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Unit</td>
                        <td>
                            <input type="hidden" name="unit_hidden" id="unit_hidden">
                            <select name="unit" id="select_unit" class="form-control" required>
                                {{-- select unit --}}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Wastage</td>
                        <td><input type="number" name="wastage" placeholder="wastage" class="form-control">
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status" class="form-control" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="false">FALSE</option>
                                <option value="true">TRUE</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td><textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                        </td>
                    </tr>
                    <td></td>
                    <td>
                        <button type="button" id="btn-tambah" onclick="tambahData()"
                            class="btn btn-primary">Tambah</button>
                        <button type="button" id="btn-ubah" onclick="ubahDataDetail()"
                            class="btn btn-primary">Ubah</button>
                        <button type="button" data-dismiss="modal" class="btn btn-primary"
                            onclick="clearModalDetail()">Batal</button>
                    </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#fabric_construct').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabricconst') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                                $('#id_fabric_constructlist').fadeIn();
                                $('#id_fabric_constructlist').html(data);
                            } else {
                                $('#id_fabric_constructlist').fadeOut();
                                $('#id_fabric_constructlist').empty();
                                $('#id_fabric_construct').val('');
                                $('#fabric_construct').val('');
                            }
                        }
                    });
                }
            });
            $('#fabric_compost').keyup(function(){
                var query = $(this).val();
                var fabricconstruct_id = $('#id_fabric_construct').val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabriccomp') }}",
                    method:"POST",
                    data:{query:query, fabricconstruct_id:fabricconstruct_id, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#id_fabric_compostlist').fadeIn();
                            $('#id_fabric_compostlist').html(data);
                            } else {
                            $('#id_fabric_compostlist').fadeOut();
                            $('#id_fabric_compostlist').empty();
                            $('#id_fabric_compost').val('');
                            $('#fabric_compost').val('');
                            }
                        }
                    });
                }
            });

            $('#gmt_color').keyup(function(){
                var query = $(this).val();
                var gmt_color_id = $('#id_gmt_color').val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.color') }}",
                        method:"POST",
                        data:{query:query, gmt_color_id:gmt_color_id, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#id_gmt_colorlist').fadeIn();
                                $('#id_gmt_colorlist').html(data);
                            } else {
                                $('#id_gmt_colorlist').fadeOut();
                                $('#id_gmt_colorlist').empty();
                                $('#id_gmt_color').val('');
                                $('#gmt_color').val('');
                            }
                        }
                    });
                }
            });

            $('#gmt_size').keyup(function(){
                var query = $(this).val();
                var gmt_size_id = $('#id_gmt_size').val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.size') }}",
                        method:"POST",
                        data:{query:query, gmt_size_id:gmt_size_id, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#id_gmt_sizelist').fadeIn();
                                $('#id_gmt_sizelist').html(data);
                            } else {
                                $('#id_gmt_sizelist').fadeOut();
                                $('#id_gmt_sizelist').empty();
                                $('#id_gmt_size').val('');
                                $('#gmt_size').val('');
                            }
                        }
                    });
                }
            });


        });

        function pilihFabricconstruct($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_construct').val($('#id_fabricconst'+ls).text());
            $('#fabric_construct').val($('#fabricconst'+ls).text());
            $('#id_fabric_constructlist').fadeOut();
        }

        function pilihFabriccompost($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_fabric_compost').val($('#id_fabriccomp'+ls).text());
            $('#fabric_compost').val($('#fabriccomp'+ls).text());
            $('#id_fabric_compostlist').fadeOut();
        }

        function pilihColor($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_gmt_color').val($('#code_col'+ls).text());
            $('#gmt_color').val($('#col'+ls).text());
            $('#id_gmt_colorlist').fadeOut();
        }

        function pilihSize($ls){
            var ls = $ls;
            var ls = $ls;
            $('#id_gmt_size').val($('#code_siz'+ls).text());
            $('#gmt_size').val($('#siz'+ls).text());
            $('#id_gmt_sizelist').fadeOut();
        }

        function getDatas(page){
            keyword=$('#keyword').val();
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url : '{{URL::to("/salessamples/materialrequirements/idsample")}}?page=' + page,
                type : 'get',
                dataType: 'json',
                data:{keyword : keyword, token : _token}
                }).done(function (data) {
                    $('#tbody_main').html(data);
                    location.hash = page;
                }).fail(function (msg) {
            // alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

        function submit(perintah) {
            if (perintah == "tambah") {
                console.log('submit-add');
                clearModalDetail();
                $("#btn-ubah").hide();
                $("#btn-tambah").show();

                // ambil data unit untuk input dropdown
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: '{{URL::to("/unit/getbyajax")}}',
                    data: { _token: _token},
                    dataType: 'json',
                    success: function(data) {
                        var unit = $('[name="unit_hidden"]').val();
                        var baris = '';
                        for (var i = 0; i < data.length; i++) {
                            if(data[i].name == unit){
                                baris += '<option value="'+data[i].name+'" selected>'+data[i].name+'</option>'
                            } else {
                                baris += '<option value="'+data[i].name+'">'+data[i].name+'</option>'
                            }
                        }
                        $('#select_unit').html(baris);
                    }
                });
            } else {
                console.log('submit-edit');
                $("#btn-tambah").hide();
                $("#btn-ubah").show();

                // ambil data berdasarkan id menggunakan ajax
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    type: 'POST',
                    url: '{{URL::to("/salessamples/materialrequirements/getData")}}',
                    data: {id : perintah, _token: _token},
                    dataType: 'json',
                    success: function(data) {
                        $('[name="id2"]').val(data.id);
                        $('[name="id_sales_sample2"]').val(data.id_sales_sample);
                        $('[name="id_material_req2"]').val(data.id_material_req);
                        $('[name="gmt_color"]').val(data.gmt_color);
                        $('[name="gmt_size"]').val(data.gmt_size);
                        $('[name="mat_color"]').val(data.mat_color);
                        $('[name="mat_size"]').val(data.mat_size);
                        $('[name="quantity"]').val(data.quantity);
                        $('[name="consumption"]').val(data.consumption);
                        $('[name="per_garment"]').val(data.per_garment);
                        $('[name="unit"]').val(data.unit);
                        $('[name="unit_hidden"]').val(data.unit);
                        $('[name="wastage"]').val(data.wastage);
                        $('[name="status"]').val(data.status);
                        $('[name="note"]').val(data.note);
                    }
                });

                // ambil data unit untuk input dropdown
                $.ajax({
                    type: 'POST',
                    url: '{{URL::to("/unit/getbyajax")}}',
                    data: { _token: _token},
                    dataType: 'json',
                    success: function(data) {
                        var unit = $('[name="unit_hidden"]').val();
                        var baris = '';
                        for (var i = 0; i < data.length; i++) {
                            if(data[i].name == unit){
                                baris += '<option value="'+data[i].name+'" selected>'+data[i].name+'</option>'
                            } else {
                                baris += '<option value="'+data[i].name+'">'+data[i].name+'</option>'
                            }
                        }
                        $('#select_unit').html(baris);
                    }
                });
            }
        }

        function tambahData()
        {
            var id_sales_sample = $("[name= 'id_sales_sample2']").val();
            var id_material_req = $("[name= 'id_material_req2']").val();
            var gmt_color = $("[name= 'gmt_color']").val();
            var gmt_size = $("[name= 'gmt_size']").val();
            var mat_color = $("[name= 'mat_color']").val();
            var mat_size = $("[name= 'mat_size']").val();
            var quantity = $("[name= 'quantity']").val();
            var consumption = $("[name= 'consumption']").val();
            var per_garment = $("[name= 'per_garment']").val();
            var unit = $("[name= 'unit']").val();
            var wastage = $("[name= 'wastage']").val();
            var status = $("[name= 'status']").val();
            var note = $("[name= 'note']").val();

            let _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: '{{URL::to("/salessamples/materialrequirements/tambah_detail")}}',
                data: { _token: _token,
                        id_sales_sample:id_sales_sample,
                        id_material_req:id_material_req,
                        gmt_color:gmt_color,
                        gmt_size:gmt_size,
                        mat_color:mat_color,
                        mat_size:mat_size,
                        quantity:quantity,
                        consumption:consumption,
                        per_garment:per_garment,
                        unit:unit,
                        wastage:wastage,
                        status:status,
                        note:note},
                dataType: 'json',
                success: function(data) {
                    $("#modal-detail").modal('hide');
                    setTimeout(function(){
                    alert(data)}, 200);
                }
            });
            $.ajax({
                type:"GET",
                url:"{{ route('materialrequirements.get_detail') }}",
                data:{id_matreq:id_material_req, _token:_token},
                dataType: 'json',
                success:function(data){
                    var baris = '';
                    for (var i = 0; i < data.length; i++) {
                        baris +='<tr>'
                        + '<td>' + (i + 1) + '</td>'
                        + '<td>' + data[i].gmt_color + '</td>'
                        + '<td>' + data[i].gmt_size + '</td>'
                        + '<td>' + data[i].mat_color + '</td>'
                        + '<td>' + data[i].mat_size + '</td>'
                        + '<td>' + data[i].quantity + '</td>'
                        + '<td>' + data[i].consumption + '</td>'
                        + '<td>' + data[i].per_garment + '</td>'
                        + '<td>' + data[i].wastage + '</td>'
                        + '<td>' + data[i].wastage + '</td>'
                        + '<td>' + data[i].unit + '</td>'
                        + '<td>' + data[i].note + '</td>'
                        + '<td>' + data[i].status + '</td>'
                        + '<td> Purchasing </td>' + '<td>'
                        + '<a onclick="hapusData(' + data[i].id + ')" class=" btn btn-danger btn-xs tooltips"><i class="icon-x "></i></a>'
                        + '<a href="#modal-detail" data-toggle="modal" class="ml-3 btn btn-primary btn-xs" onclick="submit(' + data[i].id + ')"><i class="icon-pencil"></i></a>'
                        + '</td>'
                        + '</tr>' ;
                    }
                    $('#tbody_detail').html(baris);
                }
            });
        }

        function ubahDataDetail()
        {
            var id = $("[name= 'id2']").val();
            var id_sales_sample = $("[name= 'id_sales_sample2']").val();
            var id_material_req = $("[name= 'id_material_req2']").val();
            var gmt_color = $("[name= 'gmt_color']").val();
            var gmt_size = $("[name= 'gmt_size']").val();
            var mat_color = $("[name= 'mat_color']").val();
            var mat_size = $("[name= 'mat_size']").val();
            var quantity = $("[name= 'quantity']").val();
            var consumption = $("[name= 'consumption']").val();
            var per_garment = $("[name= 'per_garment']").val();
            var unit = $("[name= 'unit']").val();
            var wastage = $("[name= 'wastage']").val();
            var status = $("[name= 'status']").val();
            var note = $("[name= 'note']").val();

            console.log(id);
            let _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'POST',
                url: '{{URL::to("/salessamples/materialrequirements/update_detail")}}',
                data: { _token: _token,
                        id:id,
                        id_sales_sample:id_sales_sample,
                        id_material_req:id_material_req,
                        gmt_color:gmt_color,
                        gmt_size:gmt_size,
                        mat_color:mat_color,
                        mat_size:mat_size,
                        quantity:quantity,
                        consumption:consumption,
                        per_garment:per_garment,
                        unit:unit,
                        wastage:wastage,
                        status:status,
                        note:note},
                dataType: 'json',
                success: function(data) {
                    $("#modal-detail").modal('hide');
                    setTimeout(function(){
                    alert(data)}, 200);
                }
            });

                        $.ajax({
            type:"GET",
            url:"{{ route('materialrequirements.get_detail') }}",
            data:{id_matreq:id_material_req, _token:_token},
            dataType: 'json',
            success:function(data){
            var baris = '';
            for (var i = 0; i < data.length; i++) { baris +='<tr>' + '<td>' + (i + 1) + '</td>' + '<td>' + data[i].gmt_color
                + '</td>' + '<td>' + data[i].gmt_size + '</td>' + '<td>' + data[i].mat_color + '</td>' + '<td>' + data[i].mat_size
                + '</td>' + '<td>' + data[i].quantity + '</td>' + '<td>' + data[i].consumption + '</td>' + '<td>' +
                data[i].per_garment + '</td>' + '<td>' + data[i].wastage + '</td>' + '<td>' + data[i].wastage + '</td>' + '<td>' +
                data[i].unit + '</td>' + '<td>' + data[i].note + '</td>' + '<td>' + data[i].status + '</td>'
                + '<td> Purchasing </td>' + '<td>' + '<a onclick="hapusData(' + data[i].id
                + ')" class=" btn btn-danger btn-xs tooltips"><i class="icon-x "></i></a>'
                + '<a href="#modal-detail" data-toggle="modal" class="ml-3 btn btn-primary btn-xs" onclick="submit(' + data[i].id
                + ')"><i class="icon-pencil"></i></a>' + '</td>' + '</tr>' ; } $('#tbody_detail').html(baris); } });
        }

        function hapusData(id, id_matreq) {
            var tanya = confirm('Apakah anda yakin akan menghapus data?');

            if (tanya) {


                let _token = $('input[name="_token"]').val();
                $.ajax({
                    type: "POST",
                    url: '{{URL::to("/salessamples/materialrequirements/hapus_detail")}}',
                    data: {id:id, _token:_token} ,
                    dataType: "json",
                    success: function(data){
                        console.log('submit-delete');
                        setTimeout(function(data){
                        alert('Data Material Detail Deleted')}, 200);
                    }
                });
                $.ajax({
                type:"GET",
                url:"{{ route('materialrequirements.get_detail') }}",
                data:{id_matreq:id_matreq, _token:_token},
                dataType: 'json',
                success:function(data){
                var baris = '';
                for (var i = 0; i < data.length; i++) { baris +='<tr>' + '<td>' + (i + 1) + '</td>' + '<td>' + data[i].gmt_color
                    + '</td>' + '<td>' + data[i].gmt_size + '</td>' + '<td>' + data[i].mat_color + '</td>' + '<td>' + data[i].mat_size
                    + '</td>' + '<td>' + data[i].quantity + '</td>' + '<td>' + data[i].consumption + '</td>' + '<td>' +
                    data[i].per_garment + '</td>' + '<td>' + data[i].wastage + '</td>' + '<td>' + data[i].wastage + '</td>' + '<td>' +
                    data[i].unit + '</td>' + '<td>' + data[i].note + '</td>' + '<td>' + data[i].status + '</td>'
                    + '<td> Purchasing </td>' + '<td>' + '<a onclick="hapusData(' + data[i].id
                    + ')" class=" btn btn-danger btn-xs tooltips"><i class="icon-x "></i></a>'
                    + '<a href="#modal-detail" data-toggle="modal" class="ml-3 btn btn-primary btn-xs" onclick="submit(' + data[i].id
                    + ')"><i class="icon-pencil"></i></a>' + '</td>' + '</tr>' ; } $('#tbody_detail').html(baris); } });
            }
        }

        function clearModalDetail()
        {
            $('[name="id"]').val('');
            $('[name="id_sales_sample"]').val('');
            $('[name="id_material_req"]').val('');
            $('[name="gmt_color"]').val('');
            $('[name="gmt_size"]').val('');
            $('[name="mat_color"]').val('');
            $('[name="mat_size"]').val('');
            $('[name="quantity"]').val('');
            $('[name="consumption"]').val('');
            $('[name="per_garment"]').val('');
            $('[name="unit"]').val('');
            $('[name="wastage"]').val('');
            $('[name="status"]').val('');
            $('[name="note"]').val('');
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            $(document).on("click","#row_detail", function(){

                let id_matreq = $(this).data("id");
                let number_mat = $(this).data("number");
                let id_sales_sample = $(this).data("idsales");

                $('#set_number_detail').html('Number : ' + number_mat);
                document.getElementById("id_sales_sample2").value = id_sales_sample;
                document.getElementById("id_material_req2").value = id_matreq;

                let _token = $('input[name="_token"]').val();
                $.ajax({
                    type:"GET",
                    url:"{{ route('materialrequirements.get_detail') }}",
                    data:{id_matreq:id_matreq, _token:_token},
                    dataType: 'json',
                    success:function(data){
                        var baris = '';
                        for (var i = 0; i < data.length; i++) {
                            baris += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + data[i].gmt_color + '</td>' +
                            '<td>' + data[i].gmt_size + '</td>' +
                            '<td>' + data[i].mat_color + '</td>' +
                            '<td>' + data[i].mat_size + '</td>' +
                            '<td>' + data[i].quantity + '</td>' +
                            '<td>' + data[i].consumption + '</td>' +
                            '<td>' + data[i].per_garment + '</td>' +
                            '<td>' + data[i].wastage + '</td>' +
                            '<td>' + data[i].wastage + '</td>' +
                            '<td>' + data[i].unit + '</td>' +
                            '<td>' + data[i].note + '</td>' +
                            '<td>' + data[i].status + '</td>' +
                            '<td> Purchasing </td>' +
                            '<td>'+
                                '<a onclick="hapusData(' + data[i].id + ',' + data[i].id_material_req + ')" class=" btn btn-danger btn-xs tooltips"><i class="icon-x "></i></a>' + '<a href="#modal-detail" data-toggle="modal" class="ml-3 btn btn-primary btn-xs" onclick="submit(' + data[i].id +')"><i class="icon-pencil"></i></a>'
                            '</td>' +
                            '</tr>';
                            }
                        $('#tbody_detail').html(baris);
                        document.getElementById("btn-modal-detail").className = "btn btn-primary";
                    }
                });
            });
        });
    </script>


    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
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
