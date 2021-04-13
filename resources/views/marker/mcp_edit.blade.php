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

                    <form action="/mcp/update" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Order</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{$result->id}}">
                                                <label for="number">Number</label>
                                                <input type="text" name="number" id="number" class="form-control"
                                                    placeholder="Number" value="{{$result->number}}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="order_name">Oder Name</label>
                                                <input id="order_name" type="text"
                                                    class="form-control @error('order_name') is-invalid @enderror"
                                                    name="order_name" value="{{ $result->order_name }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="fabricconst">Fabric Construct</label>
                                                <input type="hidden" id="id_fabricconst" type="text"
                                                    class="form-control @error('id_fabricconst') is-invalid @enderror"
                                                    name="id_fabricconst" value="{{ old('id_fabricconst') }}" required
                                                    autocomplete="off">
                                                <input id="fabricconst" type="text"
                                                    class="form-control @error('fabricconst') is-invalid @enderror"
                                                    name="fabricconst" value="{{ $result->fabric_const }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="fabricconstlist"></div>
                                                </span>

                                                @error('fabricconst')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="fabriccomp">Fabric Compost</label>
                                                <input id="fabriccomp" type="text"
                                                    class="form-control @error('fabriccomp') is-invalid @enderror"
                                                    name="fabriccomp" value="{{ $result->fabric_comp }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="fabriccomplist"></div>
                                                </span>

                                                @error('fabriccomp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="fabric_desc">Fabric Description (opt)</label>
                                                <textarea type="text" rows="2" name="fabric_desc"
                                                    class="form-control">{{$result->fabric_desc}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="style">Style</label>
                                                <input id="style" type="text"
                                                    class="form-control @error('style') is-invalid @enderror"
                                                    name="style" value="{{ $result->style }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="stylelist"></div>
                                                </span>

                                                @error('style')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="style_desc">Style Description (opt)</label>
                                                <textarea type="text" rows="2" name="style_desc"
                                                    class="form-control">{{$result->style_desc}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="delivery_date">Delivery Date</label>
                                                <input type="date" name="delivery_date" id="delivery_date"
                                                    class="form-control" placeholder=""
                                                    value="{{$result->delivery_date}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="revision_count">Revision Count</label>
                                                <input type="number" step="0.1" name="revision_count"
                                                    class="form-control" placeholder="0.0"
                                                    value="{{$result->revision_count}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="revisi_remark">Revisi Remark (opt)</label>
                                                <textarea type="text" rows="2" name="revisi_remark"
                                                    class="form-control">{{$result->revisi_remark}}</textarea>
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
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{url('/mcp/detail/'.$result->id)}}" type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</a>
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
        $('#fabricconst').keyup(function(){
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
        $('#fabricconstlist').fadeIn();
        $('#fabricconstlist').html(data);
        } else {
        $('#fabricconstlist').fadeOut();
        $('#fabricconstlist').empty();
        $('#id_fabricconst').val('');
        $('#fabricconst').val('');
        }
        }
        });
        }
        });

        $('#fabriccomp').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
        var _token = $('input[name="_token"]').val();
        var id_fabricconst = $('#id_fabricconst').val();
        $.ajax({
        url:"{{ route('autocomplete.fabriccomp') }}",
        method:"POST",
        data:{query:query, _token:_token, id_fabricconst},
        success:function(data){
        if (data!='') {
        $('#fabriccomplist').fadeIn();
        $('#fabriccomplist').html(data);
        } else {
        $('#fabriccomplist').fadeOut();
        $('#fabriccomplist').empty();
        $('#fabriccomp').val('');
        }
        }
        });
        }
        });

        $('#style').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
        var _token = $('input[name="_token"]').val();
        var id_fabricconst = $('#id_fabricconst').val();
        $.ajax({
        url:"{{ route('autocomplete.style') }}",
        method:"POST",
        data:{query:query, _token:_token, id_fabricconst},
        success:function(data){
        if (data!='') {
        $('#stylelist').fadeIn();
        $('#stylelist').html(data);
        } else {
        $('#stylelist').fadeOut();
        $('#stylelist').empty();
        $('#style').val('');
        }
        }
        });
        }
        });

        });

        function pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabricconst').val($('#id_fabricconst'+ls).text());
        $('#fabricconst').val($('#fabricconst'+ls).text());
        $('#fabricconstlist').fadeOut();
        }
        function pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#fabriccomp').val($('#fabriccomp'+ls).text());
        $('#fabriccomplist').fadeOut();
        }
        function pilihStyle($ls){
        var ls = $ls;
        var ls = $ls;
        $('#style').val($('#sty'+ls).text());
        $('#stylelist').fadeOut();
        }

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
