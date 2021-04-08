@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salesorders') }}">Master Sales Order</a></li>
        <li class="breadcrumb-item active">images</a></li>
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

    <?php $id_sales_order = Request::segment(3); ?>
    <input type="hidden" name="idsalesorder" id="idsalesorder" value="{{$id_sales_order}}">

    <div class="row">
        <div class="col-lg-12">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="/so_assortment/{{$id_sales_order}}">Assortment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salesorders/sizespecs/{{$id_sales_order}}">Size Specs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salesorders/remark/{{$id_sales_order}}">Remark</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/salesorders/materialrequirements/{{$id_sales_order}}">Material
                            Requirements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/salesorders/images/{{$id_sales_order}}">Images</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Image Of Sample
        </div>
        <div class="card-body">
            <div align="right">
                <a href="/salesorders/image/new/{{$id_sales_order}}" data-toggle="modal" data-target="#modal"
                    class="btn btn-primary"><i class="icon-pencil"></i>
                    Add New Image</a>
            </div>
            <br>

            <div class="row">
                @foreach ($result as $res)

                <div class="col-sm-3">
                    <div class="d-flex justify-content-center">
                        <span class="text-uppercase font-weight-bold">{{$res->image_type}}</span>
                    </div>
                    <div class="d-flex justify-content-center d-block mt-3">
                        <img src="{{ url('sales_file/order/' . $res->source) }}" alt="sample's-image" class=""
                            style="min-height: 30vh; max-height: 30vh; max-width: 40vh;">
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <a href="/salesorders/image/edit/{{$res->id}}/{{$res->id_sales_order}}"
                            class="btn btn-sm btn-info mr-1">Edit</a>
                        <a href="/salesorders/image/delete/{{$res->id}}/{{$res->id_sales_order}}"
                            onclick="return confirm('hapus image, lanjutkan?')"
                            class="btn btn-sm btn-danger ml-1">Delete</a>
                    </div>
                </div>

                @endforeach
            </div>

        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/salesorders/image/upload/{{$id_sales_order}}" method="post"
                    enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Order's Image</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="image_type">Image Type</label>
                                    <select name="image_type" id="image_type" class="form-control" required>
                                        <option value="" selected>-- Choose --</option>
                                        <option value="letak aksesoris">Letak Aksesoris</option>
                                        <option value="cara ukur">Cara Ukur</option>
                                        <option value="skecth">Skecth</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="source">File Image</label>
                                    <input type="file" name="source" id="source" class="form-control" required>
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

    keyword=$('#keyword').val();

		$.ajax({
			url : '{{URL::to("/salessamples/materialrequirements/idsample")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'keyword' : keyword}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			// alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

    </script>
