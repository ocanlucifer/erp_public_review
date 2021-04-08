
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
    <div class=""> 
	
  	<ol class="breadcrumb">
      	<li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      	<li class="breadcrumb-item active">Quotation</li>
  	</ol>

        <div class="card">
            <div class="card-header">
                Data Quotation
            </div>
            <div class="card-body">
            <div align="right">
              <a href="/quotation/new" class="btn btn-primary">Input New Quotation</a> &nbsp Or &nbsp
              <a href="/quotation/import" class="btn btn-success">Import From Excel Template</a>
            </div>
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr class="card-header">
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Brand</th>
                            <th>Season</th>
                            <th>Style</th>
                            <th>Business Unit</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                        </tr>

                        <tr>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Code" id="code" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Customer" id="cust" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 100 !important;" placeholder="Brand" id="brand" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 100 !important;" placeholder="Season" id="season" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 100 !important;" placeholder="Style" id="style" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Business Unit" id="bu" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Created By" id="create_by" autocomplete="off">
                            </td>
                            <td>
                              <input type="text" class="form-control" onkeyup="getDatas('')" style="min-width: 80 !important;" placeholder="Updated By" id="update_by" autocomplete="off">
                            </td>
                        </tr>
                    </thead>
                    <tbody id="view">
                    	@include('quotation.list')
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
      	cust=$('#cust').val();
      	brand=$('#brand').val();
      	season=$('#season').val();
      	style=$('#style').val();
      	bu=$('#bu').val();
        create_by=$('#create_by').val();
      	update_by=$('#update_by').val();

		$.ajax({
			url : '{{URL::to("/quotation")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'code':code,'cust':cust,'brand':brand,'season':season,'style':style,'bu':bu,'create_by':create_by,'update_by':update_by}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

  // $(document).ready(function(){

  //   $('#custdasd').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  //   $('#brandadsasd').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  //   $('#seasonasdad').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  //   $('#styleasafsa').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  //   $('#buasasfsa').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  //   $('#create_bysfasfas').on('keyup',function(){
  //     $cust=$('#cust').val();
  //     $brand=$('#brand').val();
  //     $season=$('#season').val();
  //     $style=$('#style').val();
  //     $bu=$('#bu').val();
  //     $create_by=$('#create_by').val();
  //     $.ajax({
  //       type : 'get',
  //       url : '{{URL::to("/quotation")}}',
  //       data:{'cust':$cust,'brand':$brand,'season':$season,'style':$style,'bu':$bu,'create_by':$create_by},
  //       success:function(data){
  //         $('tbody').html(data);
  //       }
  //     });
  //   });

  // });

</script>