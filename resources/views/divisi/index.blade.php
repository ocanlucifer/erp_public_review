@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Divisi</li>
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
            Master Divisi
        </div>
        <div class="card-body">
            <div align="right">
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    Nama Divisi Baru</a>
            </div>
            <br>
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr class="card-header">
                        <th>ID Divisi</th>
                        <th>Nama Divisi</th>
                        <th>#</th>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="text" class="form-control" onkeyup="getDatas('')"
                                style="min-width: 80 !important;" placeholder="Nama Divisi" id="nama_divisi"
                                autocomplete="off">
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="view">
                    @include('divisi.list')
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div id="modal" class="modal fade">
        <div class="modal-dialog">
            <form action="/divisi/new" method="post">
                {{ csrf_field() }}
                <div class="modal-content" id="background-body2">
                    <div class="modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>Nama Divisi</strong></h6>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="nama_divisi" class="form-control"
                                    style="text-transform:uppercase" placeholder="Nama divisi" value="" autofocus
                                    required>
                            </div>
                        </div>
                        <br>
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
            <form action="/divisi/update" method="post">
                {{ csrf_field() }}
                <div class="modal-content" id="background-body2">
                    <div class="modal-header bg-indigo-600">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h6 class="modal-title"><strong>Edit Nama Divisi</strong></h6>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" readonly value="{{$q->id}}" name="id" required class="form-control">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="nama_divisi" class="form-control"
                                    style="text-transform:uppercase" placeholder="Nama divisi"
                                    value="{{$q->nama_divisi}}" autofocus required>
                            </div>
                        </div>
                        <br>
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

    nama_divisi=$('#nama_divisi').val();

		$.ajax({
			url : '{{URL::to("/divisi")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'nama_divisi':nama_divisi}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

</script>
