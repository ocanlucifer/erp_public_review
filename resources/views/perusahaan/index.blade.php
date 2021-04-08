
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">Master Perusahaan</li>
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
                Master Perusahaan
            </div>
            <div class="card-body">
            <div align="right">
              <a href="#" data-toggle="modal" data-target="#modal"class="btn btn-primary"><i class="icon-pencil"></i> Data Perusahaan Baru</a>
            </div>
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th>Kode Perusahaan</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat</th>
                            <th>Phone</th>
                            <th><center>Logo</center></th>
                            <th><center>#</center></th>
                        </tr>

                        <tr>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Kd Perusahaan" id="kd_perusahaan" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Nama Divisi" id="nama_perusahaan" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Alamat" id="alamat" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('perusahaan.list')
                    </tbody>
                </table>
            </div>
        </div>
    </div> 

<div class="row">
  <div id="modal" class="modal fade">
    <div class="modal-dialog">
      <form action="/perusahaan/new" method="post" enctype='multipart/form-data'>
        {{ csrf_field() }}
      <div class="modal-content" id="background-body2">
        <div class="modal-header bg-indigo-600">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title"><strong>Data Perusahaan</strong></h6>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="kd_perusahaan" class="form-control" style="text-transform:uppercase" placeholder="Kode Perusahaan" value="" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="phone" class="form-control" placeholder="Phone" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <label for="file">Logo</label>
              <input type="file" accept="image/*" id="file" name="logo" class="form-control" required>
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
  <div id="modal_edit{{ $q->kd_perusahaan }}" class="modal fade">
    <div class="modal-dialog">
      <form action="/perusahaan/update" method="post" enctype='multipart/form-data'>
        {{ csrf_field() }}
      <div class="modal-content" id="background-body2">
        <div class="modal-header bg-indigo-600">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title"><strong>Edit Data Perusahaan</strong></h6>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="kd_perusahaan" class="form-control" style="text-transform:uppercase" placeholder="Kode Perusahaan" value="{{$q->kd_perusahaan}}" required readonly>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nama_perusahaan" class="form-control" placeholder="Nama Perusahaan" value="{{$q->nama_perusahaan}}" autofocus required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="{{$q->alamat}}" required>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{$q->phone}}">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <label for="file">Logo</label>
              <input type="file" accept="image/*" id="file" name="logo" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <img src="{{ url($q->logo) }}" height="70" align="middle">
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

    kd_perusahaan=$('#kd_perusahaan').val();
    nama_perusahaan=$('#nama_perusahaan').val();
    alamat=$('#alamat').val();

		$.ajax({
			url : '{{URL::to("/perusahaan")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'kd_perusahaan':kd_perusahaan,'nama_perusahaan':nama_perusahaan,'alamat':alamat,}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

</script>