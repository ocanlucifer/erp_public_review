
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">Manage User</li>
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
                Manage User
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th>VERIFIED</th>
                            <th>EMAIL</th>
                            <th>NAME</th>
                            <th><center>PERUSAHAAN</center></th>
                            <th><center>DIVISI</center></th>
                            <th><center>ROLE</center></th>
                            <th><center>Action</center></th>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Email" id="email" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Name" id="name" autocomplete="off">
                            </td>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Divisi" id="divisi" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Role" id="role" autocomplete="off">
                            </td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('manage_user.list')
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
@foreach($result as $q)
<div class="row">
  <div id="modal_edit{{ $q->id }}" class="modal fade">
    <div class="modal-dialog">
      <form action="/manage_user/updateRole" method="post">
        {{ csrf_field() }}
      <div class="modal-content" id="background-body2">
        <div class="modal-header bg-indigo-600">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h6 class="modal-title">Select New Role for user <b>{{$q->name}}</b></h6>
        </div>
        <div class="modal-body">
          <input type="hidden" readonly value="{{$q->id}}" name="id" required class="form-control" >
          <div class="form-group">
            <div class='col-md-9'>
            <div class="input-group">
              <select class="form-control" name="newrole">
                <option value="{{$q->hak_akses}}" selected>{{ $q->hak_akses }}</option>
                <option value="IT">IT</option>
                <option value="SAP">SAP</option>
                <option value="DIR">DIR</option>
                <option value="USER">USER</option>
              </select>
            </div>
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

    name=$('#name').val();
    divisi=$('#divisi').val();
    role=$('#role').val();
    email=$('#email').val();

		$.ajax({
			url : '{{URL::to("/manage_user")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'name':name,'divisi':divisi,'role':role,'email':email}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

</script>