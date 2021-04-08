
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">Approved PO</li>
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
                View Approved PO
            </div>
            <div class="card-body">
            <!-- <div align="right">
              <a href="/pengajuan/new" class="btn btn-primary">Tambah Pengajuan</a>
            </div> -->
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th>No. Pengajuan</th>
                            <th><center>Dokumen</center></th>
                            <th><center>Created By</center></th>
                            <th><center>Created At</center></th>
                            <th><center>Bagian</center></th>
                            <th><center>Checked 1</center></th>
                            <th><center>Checked 1 At</center></th>
                            <th><center>Checked 2</center></th>
                            <th><center>Checked 2 At</center></th>
                            <th><center>Checked 2 Note</center></th>
                        </tr>

                        <tr>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="No. Pengajuan" id="no_pengajuan" autocomplete="off">
                            </td>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Created By" id="create_by" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Created At" id="created_at" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Bagian" id="bagian" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Checked 1" id="approved_1_by" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Checked 1 At" id="approved_1_at" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('approved.list')
                    </tbody>
                </table>
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

      	no_pengajuan=$('#no_pengajuan').val();
      	bagian=$('#bagian').val();
        create_by=$('#create_by').val();
        created_at=$('#created_at').val();
        approved_by=$('#approved_1_by').val();
      	approved_at=$('#approved_1_at').val();

		$.ajax({
			url : '{{URL::to("/po_approved")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'no_pengajuan':no_pengajuan,'bagian':bagian,'create_by':create_by,'created_at':created_at,'approved_1_by':approved_by,'approved_1_at':approved_at}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

</script>