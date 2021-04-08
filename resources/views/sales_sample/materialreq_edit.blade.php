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

    <?php $id_sales_sample = Request::segment(5); ?>

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
                        <a class="nav-link" href="/salessamples/image/{{$id_sales_sample}}">Image</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="card-body">

                    <form action="/salessamples/materialrequirements/update/{{$id_sales_sample}}" method="post"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Material Requirements</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id" value="{{$result->id}}">
                                            <input type="hidden" name="number" id="number" value="{{$result->number}}">
                                            <input type="hidden" name="id_sales_sample" id="id_sales_sample"
                                                value="{{$result->id_sales_sample}}">

                                            <div class="input-group">
                                                <label for="fabric_construct">Fabric Construct</label>
                                                <input type="hidden" id="id_fabric_construct" type="text"
                                                    class="form-control @error('id_fabric_construct') is-invalid @enderror"
                                                    name="id_fabric_construct" value="{{$result->id_fabric_construct}}"
                                                    required autocomplete="off">
                                                <input id="fabric_construct" type="text"
                                                    class="form-control @error('fabric_construct') is-invalid @enderror"
                                                    name="fabric_construct" value="{{ $result->fabricconst['name'] }}"
                                                    required autocomplete="off">
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
                                                    name="id_fabric_compost" value="{{$result->id_fabric_compost}}"
                                                    required autocomplete="off">
                                                <input id="fabric_compost" type="text"
                                                    class="form-control @error('fabric_compost') is-invalid @enderror"
                                                    name="fabric_compost" value="{{ $result->fabriccomp['name'] }}"
                                                    required autocomplete="off">
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
                                                <label for="fabric_description">Fabric Description</label>
                                                <textarea class="form-control" name="fabric_description"
                                                    id="fabric_description"
                                                    rows="3">{{$result->fabric_description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="budget">Budget</label>
                                                <input type="number" name="budget" id="budget" class="form-control"
                                                    value="{{$result->budget}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="po_status">PO Status</label>
                                                <select class="form-control" name="po_status" id="po_status" required>
                                                    <option value="false" @if ($result->po_status == "false")
                                                        {{ 'selected' }}
                                                        @endif>False</option>
                                                    <option value="true" @if ($result->po_status ==
                                                        "true")
                                                        {{ 'selected' }}
                                                        @endif>True</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="state">State</label>
                                                <select class="form-control" name="state" id="state" required>
                                                    <option value="pending" @if ($result->state == "pending")
                                                        {{ 'selected' }}
                                                        @endif>Pending</option>
                                                    <option value="unconfirmed" @if ($result->state == "unconfirmed")
                                                        {{ 'selected' }}
                                                        @endif>Unconfirmed</option>
                                                    <option value="confirmed" @if ($result->state == "confirmed")
                                                        {{ 'selected' }}
                                                        @endif>Confirmed</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- Purchasing auto get --}}

                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="note">Note</label>
                                                <textarea class="form-control" name="note" id="note"
                                                    rows="3">{{$result->note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{url('/salessamples/materialrequirements/' . $id_sales_sample)}}"
                                        type="button" class="btn btn-default" data-dismiss="modal">Close</a>
                                    <button type="submit" class="btn btn-warning">Submit</button>
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
        $(document).ready(function(){
            $('#fabric_construct').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.fabricconst') }}" , method:"POST", data:{query:query, _token:_token},
                                        success:function(data){ if (data!='' ) { $('#id_fabric_constructlist').fadeIn();
                                        $('#id_fabric_constructlist').html(data); } else {
                                        $('#id_fabric_constructlist').fadeOut(); $('#id_fabric_constructlist').empty();
                                        $('#id_fabric_construct').val(''); $('#fabric_construct').val(''); } } }); } });

            $('#fabric_compost').keyup(function(){ var query=$(this).val(); if(query !='' ){
                var _token=$('input[name="_token" ]').val();
                var fabricconstruct_id = $('#id_fabric_construct').val();
                $.ajax({
                    url:"{{ route('autocomplete.fabriccomp') }}",
                    method:"POST",
                    data:{query:query, fabricconstruct_id:fabricconstruct_id, _token:_token}, success:function(data){ if (data!='' ) {
                                        $('#id_fabric_compostlist').fadeIn(); $('#id_fabric_compostlist').html(data); }
                                        else { $('#id_fabric_compostlist').fadeOut();
                                        $('#id_fabric_compostlist').empty(); $('#id_fabric_compost').val('');
                                        $('#fabric_compost').val(''); } } }); } }); });

            function pilihFabricconstruct($ls){ var ls=$ls; var ls=$ls;
                                        $('#id_fabric_construct').val($('#id_fabricconst'+ls).text());
                                        $('#fabric_construct').val($('#fabricconst'+ls).text());
                                        $('#id_fabric_constructlist').fadeOut(); }

            function pilihFabriccompost($ls){ var
                                        ls=$ls; var ls=$ls; $('#id_fabric_compost').val($('#id_fabriccomp'+ls).text());
                                        $('#fabric_compost').val($('#fabriccomp'+ls).text());
                                        $('#id_fabric_compostlist').fadeOut(); }
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

	function getDatas(page){

    number=$('#number').val();

		$.ajax({
			url : '{{URL::to("/salesorders")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'number' : number}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

    </script>
