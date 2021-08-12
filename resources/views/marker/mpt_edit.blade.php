@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/mp')}}">Production Marker</a></li>
        <li class="breadcrumb-item"><a href="/mp/detail/{{$mp}}">Marker</a></li>
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

                    <form action="/mp/update_mpt" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-content" id="modal-content" style="width: 100%;">
                            <div class="modal-header">
                                <h3>Edit Types</h3>
                            </div>
                            {{-- <input type="hidden" name="mp" id="mp" value="{{$mp->number}}"> --}}
                            <input type="hidden" name="id" id="id" value="{{$mpt->id}}">
                            <input type="hidden" name="mp" id="mp" value="{{$mpt->mp}}">
                            <input type="hidden" name="id_wsheet" id="id_wsheet" value="{{$mpt->id_wsheet}}">
                            <input type="hidden" name="created_by" id="created_by" value="{{$mpt->created_by}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">No Urut</div>
                                    <div class="col-sm-8"><input class="form-control" type="number" id="no_urut"
                                            name="no_urut" value="{{$mpt->no_urut}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Fab Description</div>
                                    <div class="col-sm-8"><input class="form-control" type="text" name="fabric_desc"
                                            id="fabric_desc" value="{{$mpt->fabricdesc}}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Warna</div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="color" type="text"
                                                class="form-control @error('color') is-invalid @enderror" name="color"
                                                value="{{$mpt->warna}}" required autocomplete="off">
                                            <span>
                                                <div id="colorlist"></div>
                                            </span>

                                            @error('color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    {{ csrf_field() }}
                                    <div class="col-sm-4 text-right">Type</div>
                                    <div class="col-sm-8">
                                        {{-- <select class="form-control" name="type" id="type" required>
                                            <option value="{{$mpt->type}}" selected>{{$mpt->type}}</option>
                                        <option value="" disabled>
                                            <hr>
                                        </option>
                                        <option value="aplikasi">Aplikasi</option>
                                        <option value="marker">Marker</option>
                                        <option value="kain keras">Kain Keras</option>
                                        <option value="Piping">Piping</option>
                                        </select> --}}
                                        <input class="form-control" type="text" name="type" id="type"
                                            value="{{$mpt->type}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Component</div>
                                    <div class="col-sm-8"><select class="form-control" name="component" id="component"
                                            required>
                                            <option value="{{$mpt->component}}" selected>{{$mpt->component}}</option>
                                            <option value="body1">Body1</option>
                                            <option value="body2">Body2</option>
                                            <option value="body3">Body3</option>
                                            <option value="body4">Body4</option>
                                            <option value="body5">Body5</option>
                                            <option value="body6">Body6</option>
                                            <option value="body7">Body7</option>
                                            <option value="body8">Body8</option>
                                            <option value="body9">Body9</option>
                                            <option value="body10">Body10</option>
                                        </select></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Tujuan</div>
                                    <div class="col-sm-8"><input type="text" name="tujuan" id="tujuan"
                                            class="form-control" value="{{$mpt->tujuan}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Fab Construct</div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="hidden" id="id_fabric_construct"
                                                class="form-control @error('id_fabric_construct') is-invalid @enderror"
                                                name="id_fabric_construct" value="{{ old('id_fabric_construct') }}"
                                                required autocomplete="off">
                                            <input id="fabric_construct" type="text"
                                                class="form-control @error('fabric_construct') is-invalid @enderror"
                                                name="fabric_construct" value="{{$mpt->fabricconst }}" required
                                                autocomplete="off">
                                            <span>
                                                <div id="fabric_constructlist"></div>
                                            </span>

                                            @error('fabric_construct')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right"></div>
                                    <div class="col-sm-8"></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Remark</div>
                                    <div class="col-sm-8"><textarea class="form-control" name="remark" id="remark"
                                            cols="20" rows="2">{{$mpt->remark}}</textarea></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="col-sm-4 text-right">Fab Compost</div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="fabric_compost" type="text"
                                                class="form-control @error('fabric_compost') is-invalid @enderror"
                                                name="fabric_compost" value="{{$mpt->fabriccomp}}" required
                                                autocomplete="off">
                                            <span>
                                                <div id="fabric_compostlist"></div>
                                            </span>

                                            @error('fabric_compost')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-10">
                                <div class="col-sm-4">
                                    <input type="submit" id="submit_type" name="submit_type"
                                        class="btn btn-sm btn-primary ml-10">
                                    {{-- <button type="button" id="btn-ubah" onclick="ubahData()"
                                                    class="btn btn-primary">Ubah</button> --}}
                                    <a href="/mp/detail/{{$mp}}" class="btn btn-sm btn-primary">Kembali</a>
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
        $('#color').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
        var _token = $('input[name="_token"]').val();
        $.ajax({
        url:"{{ route('autocomplete.color') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
        if (data!='') {
        $('#colorlist').fadeIn();
        $('#colorlist').html(data);
        } else {
        $('#colorlist').fadeOut();
        $('#colorlist').empty();
        $('#color').val('');
        }
        }
        });
        }
        });

        $('#fabric_construct').keyup(function(){
        var query = $(this).val();
        if(query != ''){
        var _token = $('input[name="_token"]').val();
        $.ajax({
        url:"{{ route('autocomplete.fabricconst') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
        if (data!='') {
        $('#fabric_constructlist').fadeIn();
        $('#fabric_constructlist').html(data);
        } else {
        $('#fabric_constructlist').fadeOut();
        $('#fabric_constructlist').empty();
        $('#id_fabric_construct').val('');
        $('#fabric_construct').val('');
        }
        }
        });
        }
        });

        $('#fabric_compost').keyup(function(){
        var query = $(this).val();
        if(query != ''){
        var id_fabricconst = $('input[name="id_fabric_construct"]').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
        url:"{{ route('autocomplete.fabriccomp') }}",
        method:"POST",
        data:{query:query, id_fabricconst:id_fabricconst, _token:_token},
        success:function(data){
        if (data!='') {
        $('#fabric_compostlist').fadeIn();
        $('#fabric_compostlist').html(data);
        } else {
        $('#fabric_compostlist').fadeOut();
        $('#fabric_compostlist').empty();
        $('#fabric_compost').val('');
        }
        }
        });
        }
        });

    });
        function pilihColor($ls){
        var ls = $ls;
        var ls = $ls;
        $('#color').val($('#col'+ls).text());
        $('#colorlist').fadeOut();
        }

        function pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabric_construct').val($('#id_fabricconst'+ls).text());
        $('#fabric_construct').val($('#fabricconst'+ls).text());
        $('#fabric_constructlist').fadeOut();
        }

        function pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#fabric_compost').val($('#fabriccomp'+ls).text());
        $('#fabric_compostlist').fadeOut();
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
