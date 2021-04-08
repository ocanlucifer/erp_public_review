
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">PPN</li>
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
                PPN
            </div>
            <div class="card-body">
            <div align="right">
              <a href="#" data-toggle="modal" data-target="#modal"class="btn btn-primary"><i class="icon-pencil"></i> PPN Baru</a>
            </div>
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th>PPN</th>
                            <th>Rate</th>
                            <th><center>#</center></th>
                        </tr>

                        <tr>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="PPN" id="ppn" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('ppn.list')
                    </tbody>
                </table>
            </div>
        </div>
    </div> 

<div class="row">
  <div id="modal" class="modal fade">
    <div class="modal-dialog">
      <form action="/ppn/new" method="post" enctype='multipart/form-data'>
        {{ csrf_field() }}
      <div class="modal-content" id="background-body2">
        <div class="modal-header bg-indigo-600">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title"><strong>PPN</strong></h6>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="ppn" class="form-control" style="text-transform:uppercase" placeholder="PPN" value="" autofocus required>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <div class="input-group">
              <input type="number" name="rate" class="form-control" style="text-transform:uppercase" placeholder="Rate" value=""required>
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


<div class="row">
  <div id="modal_edit" class="modal fade">
    <div class="modal-dialog">
      <form action="/ppn/update" method="post" enctype='multipart/form-data'>
        {{ csrf_field() }}
      <div class="modal-content" id="background-body2">
        <div class="modal-header bg-indigo-600">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title"><strong>Edit PPN</strong></h6>
        </div>
        <div class="modal-body">
          <div id="editform">
            
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

    ppn=$('#ppn').val();

		$.ajax({
			url : '{{URL::to("/ppn")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'ppn':ppn,}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

  function ModalEdit(id){

    id=id;

    $.ajax({
      url : '{{URL::to("ppn/editform")}}',
      type : 'get',
      dataType: 'json',
      data:{'id':id}
    }).done(function (data) {
      $('#editform').html(data);
    }).fail(function (msg) {
      alert('Gagal menampilkan data, silahkan refresh halaman.');
    });
  }


</script>