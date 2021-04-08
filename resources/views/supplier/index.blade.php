
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">Supplier</li>
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
                Data Supplier
            </div>
            <div class="card-body">
            <div align="right">
              <a href="/supplier/new" class="btn btn-primary">Tambah Data Supplier</a>
            </div>
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th><center>Code</center></th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Contact Person</th>
                            <th>Negara</th>
                            <th>Phone</th>
                            <th><center>TOP</center></th>
                            <th>Email</th>
                            <th>NPWP</th>
                            <th><center>PPN</center></th>
                            <th><center>Bank</center></th>
                            <th>Rekening</th>
                            <th>Remarks</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
                            <th><center>Delete</center></th>
                        </tr>

                        <tr>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Code" id="code" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Nama" id="nama" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Alamat" id="alamat" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Contact" id="contact_name" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Negara" id="country" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Email" id="email" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Bank" id="bank" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('supplier.list')
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

      	code=$('#code').val();
      	nama=$('#nama').val();
        alamat=$('#alamat').val();
        contact_name=$('#contact_name').val();
        country=$('#country').val();
        email=$('#email').val();
        bank=$('#bank').val();

		$.ajax({
			url : '{{URL::to("/supplier")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'code':code,'nama':nama,'alamat':alamat,'contact_name':contact_name,'country':country,'email':email,'bank':bank}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

</script>