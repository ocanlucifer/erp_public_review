@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Marker Check Production</li>
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

    <div class="card">
        <div class="card-header">
            Marker Check Production
        </div>
        <div class="card-body">
            <div align="right">
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    New Data</a>
            </div>
            <br>

            <div class="table table-responsive">
                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr class="card-header">
                            <th>Number</th>
                            <th>Order Name</th>
                            <th>Style Name</th>
                            <th>Delivery Date</th>
                            <th>State</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                        <tr>
                            <td colspan="2">
                                {{-- <input type="hidden" name="search_number" id="search_number"> --}}
                                <input type="text" class="form-control" onkeyup="getDatas('')" name="keyword"
                                    id="keyword" placeholder="RKK Number/Customer Name/Style Name" autocomplete="off">
                            </td>
                            {{-- <td>
                                <input type="text" class="form-control" onkeyup="getDatas('')" name="search_name"
                                    id="search_name" style="max-width: 180 !important;" placeholder="Customer Name"
                                    autocomplete="off">
                            </td> --}}
                            {{-- <td>
                                <input type="text" class="form-control" onkeyup="getDatas('')" name="search_style"
                                    id="search_style" style="max-width: 180 !important;" placeholder="Style"
                                    autocomplete="off">
                            </td> --}}
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                        @include('marker.mcp_list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/mcp/create" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2" style="width:120% !important;!">
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Data Marker Check Production</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="order_name">Oder Name</label>
                                            <input id="order_name" type="text"
                                                class="form-control @error('order_name') is-invalid @enderror"
                                                name="order_name" value="{{ old('order_name') }}" autocomplete="off"
                                                required>
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
                                                name="fabricconst" value="{{ old('fabricconst') }}" required
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
                                            <input type="hidden" id="id_fabriccomp" type="text"
                                                class="form-control @error('id_fabriccomp') is-invalid @enderror"
                                                name="id_fabriccomp" value="{{ old('id_fabriccomp') }}" required
                                                autocomplete="off">
                                            <input id="fabriccomp" type="text"
                                                class="form-control @error('fabriccomp') is-invalid @enderror"
                                                name="fabriccomp" value="{{ old('fabriccomp') }}" required
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
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="style">Style</label>
                                            <input id="style" type="text"
                                                class="form-control @error('style') is-invalid @enderror" name="style"
                                                value="{{ old('style') }}" required autocomplete="off">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="style_desc">Style Description (opt)</label>
                                            <textarea type="text" rows="2" name="style_desc"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="delivery_date">Delivery Date</label>
                                            <input type="date" name="delivery_date" id="delivery_date"
                                                class="form-control" placeholder="" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="revisi_remark">Revisi Remark (opt)</label>
                                            <textarea type="text" rows="2" name="revisi_remark"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($result as $q)
    <div class="row">
        <div id="modal_edit{{ $q->id }}" class="modal fade">
            <div class="modal-dialog">
                <form action="/marker/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit Data Marker</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="id" class="form-control" style="text-transform:uppercase"
                                        placeholder="Kode Marker" value="{{$q->id}}" required readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="nama_marker" class="form-control"
                                        placeholder="Nama Currencies" value="{{$q->nama_marker}}" autofocus required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="style" class="form-control" placeholder="Style"
                                        value="{{$q->style}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
                    data:{query:query, _token:_token, id_fabricconst:id_fabricconst},
                    success:function(data){
                        if (data!='') {
                            $('#fabriccomplist').fadeIn();
                            $('#fabriccomplist').html(data);
                            } else {
                            $('#fabriccomplist').fadeOut();
                            $('#fabriccomplist').empty();
                            $('#id_fabriccomp').val('')
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
            $('#id_fabriccomp').val($('#id_fabriccomp'+ls).text());
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

        function getDatas(page)
        {
            keyword = $('#keyword').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url : '{{URL::to("/mcp")}}?page=' + page,
                type : 'get',
                dataType: 'json',
                data:{'keyword':keyword ,'_token':_token}
            }).done(function (data) {
                $('tbody').html(data);
                location.hash = page;
            }).fail(function (msg) {
                alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

    </script>
