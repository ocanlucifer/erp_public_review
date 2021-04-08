@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">
    <?php $idsample = request()->segment(count(request()->segments())); ?>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salessamples') }}">Master Sales Sample</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salessamples/remark/' . $idsample) }}">Remark</a>
        </li>
        <li class="breadcrumb-item active">Remark Type</a></li>
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

    <?php $idsalessample = Request::segment(3); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/assortment/{{$idsalessample}}">Assortment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/sizespecs/{{$idsalessample}}">Size Specs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/salessamples/remark/{{$idsalessample}}">Remark</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/materialrequirements/{{$idsalessample}}">Material
                                Requirements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/image/{{$idsalessample}}">Images</a>
                        </li>
                    </ul>

                    <div align="right">
                        <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i
                                class="icon-pencil"></i>
                            Add Data Remark Type</a>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container">

                                <table class="table table-bordered table-striped table-hover table-responsive">

                                    <thead>
                                        <tr class="card-header">
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>
                                                <center>#</center>
                                            </th>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="id" id="id">
                                                <input type="hidden" name="idsalessample" id="idsalessample"
                                                    value="{{$idsalessample}}">
                                                <input type="text" class="form-control" onkeyup="getDatas('')"
                                                    style="min-width: 80 !important;" placeholder="name" id="name"
                                                    autocomplete="off">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody id="view">
                                        @include('sales_sample.remark_type_list')
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Tambah-->
        <div class="row">
            <div id="modal" class="modal fade">
                <div class="modal-dialog">
                    <form action="/salessamples/remark_type/new/{{$idsample}}" method="post"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Add Remark Type</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Name of Remark Type" value="" required>
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

        @foreach($remark_type as $q)
        <div class="row">
            <div id="modal_edit{{ $q->id }}" class="modal fade">
                <div class="modal-dialog">
                    <form action="/salessamples/remark_type/update/{{$idsample}}" method="post"
                        enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Remark Type</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="hidden" name="id" class="form-control"
                                            style="text-transform:uppercase" placeholder="Kode Marker"
                                            value="{{$q->id}}" required readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="name of remark type" value="{{$q->name}}" autofocus required>
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

    </div>

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
        idsalessample=$('#idsalessample').val();
        name=$('#name').val();

    		$.ajax({
    			url : '{{URL::to("/salessamples/remark_type/idsalessample")}}?page=' + page,
    			type : 'get',
    			dataType: 'json',
    			data:{'id':id,'name':name,}
    		}).done(function (data) {
    			$('tbody').html(data);
    			location.hash = page;
    		}).fail(function (msg) {
    			alert('Gagal menampilkan data, silahkan refresh halaman.');
    		});
    	}

    </script>
