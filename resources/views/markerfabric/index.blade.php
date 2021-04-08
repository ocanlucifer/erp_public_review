@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/marker') }}">Master Marker</a></li>
        <li class="breadcrumb-item active">Marker Fabric</li>
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
            Master Marker Fabric
        </div>
        <div class="card-body">
            <div align="right">
                <a target="_blank" href="/markerfabric/print/{{$id_marker}}" class="btn btn-warning"><i
                        class="icon-printer"></i>
                    Print Data Marker</a>
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    Data Marker Fabric Baru</a>
            </div>
            <br>

            <table class="table table-bordered table-striped table-hover table-responsive">

                <thead>
                    <tr class="card-header">
                        <th>No.</th>
                        <th>Marker</th>
                        <th>Fabric Construct</th>
                        <th>Fabric Compost</th>
                        <th>Description</th>
                        <th>Gramasi</th>
                        <th>Unit</th>
                        <th>Marker Type</th>
                        <th>
                            <center>#</center>
                        </th>
                    </tr>
                </thead>
                <tbody id="view">
                    @include('markerfabric.list')
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/markerfabric/new" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Data Marker Fabric</strong></h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_marker" class="form-control" placeholder="Name of Marker"
                                value="{{$id_marker}}" required readonly>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="id_fabric_construct">Fabric Construct</label>
                                    <select name="id_fabric_construct" id="id_fabric_construct" class="form-control"
                                        required>
                                        <option value="" disabled selected>Choose Fabric Construct</option>
                                        @foreach ($fabricconst as $fbs)
                                        <option value="{{$fbs['id']}}">{{$fbs['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="id_fabric_compost">Fabric Compost</label>
                                    <select name="id_fabric_compost" id="id_fabric_compost" class="form-control"
                                        required>
                                        <option value="" disabled selected>Choose Fabric Compost</option>

                                    </select>
                                    {{-- <input type="text" class="form-control" name="id_fabric_compost" id=""> --}}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="name of marker"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="description of marker" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="gramasi">Gramasi</label>
                                    <input type="text" name="gramasi" class="form-control"
                                        placeholder="Gramasi of Marker" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="unit">Unit</label>
                                    <input type="text" name="unit" class="form-control" placeholder="unit of Marker"
                                        value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="marker_type">Marker Type</label>
                                    <input type="text" name="marker_type" class="form-control"
                                        placeholder="Type of Marker" value="" required>
                                </div>
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

    @foreach($result as $q)
    <div class="row">
        <div id="modal_edit{{ $q->id }}" class="modal fade">
            <div class="modal-dialog">
                <form action="/markerfabric/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit Data Marker Fabric</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" name="id" class="form-control" style="" value="{{$q->id}}">
                                    <input type="hidden" name="id_marker" class="form-control" value="{{$q->id_marker}}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="id_fabric_construct">Fabric Construct</label>
                                    <select name="id_fabric_construct" id="id_fabric_construct" class="form-control"
                                        required>
                                        <option value="" disabled selected>Choose Fabric Construct</option>
                                        @foreach ($fabricconst as $fbs)
                                        <option value="{{$fbs['id']}}" @if ($fbs['id']==$q['id_fabric_construct']) echo
                                            selected @endif>{{$fbs['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id_fabric_compost">Fabric Compost</label>
                                <select name="id_fabric_compost" id="id_fabric_compost" class="form-control" required>
                                    <option value="" disabled selected>Choose Fabric Compost</option>
                                    @foreach ($fabriccomp as $fbc)
                                    <option value="{{$fbc['id']}}" @if ($fbc['id']==$q['id_fabric_compost']) echo
                                        selected @endif>{{$fbc['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="description of marker" value="{{$q->description}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Gramasi</label>
                                <div class="input-group">
                                    <input type="text" name="gramasi" class="form-control" placeholder="gramasi"
                                        value="{{$q->gramasi}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <div class="input-group">
                                    <input type="text" name="unit" class="form-control" placeholder="unit"
                                        value="{{$q->unit}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Marker Type</label>
                                <div class="input-group">
                                    <input type="text" name="marker_type" class="form-control" placeholder="marker_type"
                                        value="{{$q->marker_type}}" required>
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
			var url = $(this).attr('href');
			getDatas($(this).attr('href').split('page=')[1]);
			e.preventDefault();
		});

        $("#id_fabric_construct").change(function(){
            var id_const = $("#id_fabric_construct").val();
            var _token = $('input[name="_token"]').val();
            var txt = '<option value="" disabled selected>Choose Fabric Compost</option>';
            var i;

            $.ajax({
                url: "{{url('/markerfabric/getcomp/')}}",
                method: "POST",
                data: {id:id_const, _token:_token},
                success:function(res){
                    var result = res.success;
                    for(i=0;i<result.length; i++)
                    {
                        console.log(result[i]);
                        txt += "<option value='" +result[i].id+ "'>" + result[i].name +"</option>"
                    }
                    $('#id_fabric_compost').html(txt);
                }, error: function(){
                    console.log('error');
                }
            });
        });

    });
    </script>
