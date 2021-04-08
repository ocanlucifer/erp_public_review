@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Fabric Composts</li>
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
            Master Fabric Composts
        </div>
        <div class="card-body">
            <div align="right">
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    Tambah Data</a>
            </div>
            <br>

            <table class="table table-bordered table-striped table-hover table-responsive">

                <thead>
                    <tr class="card-header">
                        <th>No.</th>
                        <th>Name</th>
                        <th>Fabric Construct</th>
                        <th>Item Type Name</th>
                        <th>State</th>
                        <th>
                            <center>#</center>
                        </th>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="id" id="id">
                            <input type="text" class="form-control" onkeyup="getDatas('')"
                                style="min-width: 80 !important;" placeholder="name" id="name" autocomplete="off">
                        </td>
                        <td></td>
                        <td>
                            <input type="text" class="form-control" onkeyup="getDatas('')"
                                style="min-width: 80 !important;" placeholder="Type of Item" id="type_name"
                                autocomplete="off">
                        </td>
                        <td>
                            <input type="text" class="form-control" onkeyup="getDatas('')"
                                style="min-width: 80 !important;" placeholder="State" id="state" autocomplete="off">
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="view">
                    @include('fabriccomp.list')
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/fabric_comp/new" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Data Fabric Composts</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="name">Name :</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Name of Fabric Composts" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabricconstruct_id">Id Fabric Construct</label>
                                    {{-- <input type="text" name="fabricconstruct_id" class="form-control"
                                        placeholder="Type Name of Item" value="" required> --}}
                                    <select name="fabricconstruct_id" class="form-control" required>
                                        <option value="">choose</option>
                                        @foreach ($fabricconst as $fcs)
                                        <option value="{{$fcs->id}}">{{$fcs->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="type_name">Type of Item</label>
                                    <select name="type_name" id="type_name" class="form-control">
                                        <option value="accessories">Accessories</option>
                                        <option value="auxiliaries">Auxiliaries</option>
                                        <option value="goods">Goods</option>
                                    </select>
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
                <form action="/fabric_comp/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit Data Fabric Composts</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="hidden" name="id" class="form-control" style="text-transform:uppercase"
                                        placeholder="" value="{{$q->id}}" required readonly>
                                    <label for="name">Name : </label>
                                    <input type="text" name="name" class="form-control" style="text-transform:uppercase"
                                        placeholder="Name of Fabric Composts" value="{{$q->name}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="fabricconstruct_id">Fabric Construct </label>
                                    {{-- <input type="text" name="fabricconstruct_id" class="form-control"
                                        placeholder="Fabric Construct" value="{{$q->fabricconstruct_id}}" autofocus
                                    required> --}}
                                    <select name="fabricconstruct_id" class="form-control">
                                        @foreach ($fabricconst as $fcs)
                                        <option value="{{$fcs->id}}" @if ($fcs->id == $q->fabricconstruct_id) echo
                                            selected
                                            @endif>{{$fcs->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="type_name">Item Type Name </label>
                                    {{-- <input type="text" name="type_name" class="form-control" placeholder="Type of Item"
                                        value="{{$q->type_name}}" autofocus required> --}}
                                    <select name="type_name" id="type_name" class="form-control">
                                        <option value="accessories" @if ($q->type_name == 'accessories') echo selected
                                            @endif>
                                            Accessories
                                        </option>
                                        <option value="auxiliaries" @if ($q->type_name == 'auxiliaries') echo selected
                                            @endif>
                                            Auxiliaries
                                        </option>
                                        <option value="goods" @if ($q->type_name == 'goods') echo selected
                                            @endif>
                                            Goods
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="state">State : </label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="pending" @if ($q->state == 'pending') echo selected
                                            @endif>
                                            Pending
                                        </option>
                                        <option value="confirmed" @if ($q->state == 'confirmed') echo selected
                                            @endif>
                                            Confirmed
                                        </option>
                                        <option value="unconfirmed" @if ($q->state == 'unconfirmed') echo selected
                                            @endif>
                                            Unconfirmed
                                        </option>
                                    </select>
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
			// $('tbody').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="../public/images/loading.gif" />');
			var url = $(this).attr('href');
			getDatas($(this).attr('href').split('page=')[1]);
			e.preventDefault();
		});
	});

	function getDatas(page){

    id=$('#id').val();
    name=$('#name').val();
    type_name=$('#type_name').val();
    state=$('#state').val();

		$.ajax({
			url : '{{URL::to("/fabric_comp")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'id':id,'name':name,'type_name':type_name, 'state':state}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

    </script>
