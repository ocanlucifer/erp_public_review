@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/consumption')}}">Master Consumption</a></li>
        <li class="breadcrumb-item active">Edit Data Order</li>
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

    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <div class="card-body">

                    <form action="/consumption/update" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Order</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{$result->id}}">
                                                <label for="code">Code</label>
                                                <input type="text" name="code" id="code" class="form-control"
                                                    value="{{$result->code}}" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="code_quotation">Quotation Code</label>
                                                {{-- <input type="hidden" id="code_quotation" type="text"
                                                    class="form-control @error('code_quotation') is-invalid @enderror"
                                                    name="code_quotation" value="{{ $result->quotation['code'] }}"
                                                required autocomplete="off"> --}}
                                                <input id="code_quotation" type="text"
                                                    class="form-control @error('code_quotation') is-invalid @enderror"
                                                    name="code_quotation" value="{{ $result->code_quotation }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="code_quotationlist"></div>
                                                </span>

                                                @error('code_quotation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="customer">Customer <small>(auto)</small></label>
                                                <input id="customer" type="text"
                                                    class="form-control @error('customer') is-invalid @enderror"
                                                    name="customer" value="{{ $result->customer }}" required
                                                    autocomplete="off" readonly>
                                                <span>
                                                    <div id="customerlist"></div>
                                                </span>

                                                @error('customer')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="customer_style">Customer Style <small>(auto)</small></label>
                                                <input id="customer_style" type="text"
                                                    class="form-control @error('customer_style') is-invalid @enderror"
                                                    name="customer_style" value="{{ $result->customer_style }}" required
                                                    autocomplete="off" readonly>
                                                <span>
                                                    <div id="customer_stylelist"></div>
                                                </span>

                                                @error('customer_style')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="number_mp">Number Marker Production</label>
                                                <input type="text" name="number_mp" id="number_mp" class="form-control" value="{{$result->number_mp}}" required autocomplete="off">
                                            <span>
                                                <div id="number_mcplist"></div>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="size_tengah">Size Tengah</label>
                                                <input type="text" name="size_tengah" id="size_tengah"
                                                    class="form-control" value="{{$result->size_tengah}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="delivery_date">Delivery Date <small>(auto)</small></label>
                                                <input type="date" step="0.01" name="delivery_date" id="delivery_date"
                                                    class="form-control" value="{{$result->delivery_date}}" required
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="references_date">References Date
                                                    <small>(auto)</small></label>
                                                <input type="date" step="0.01" name="references_date"
                                                    id="references_date" class="form-control"
                                                    value="{{$result->references_date}}" required readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="net_price">Garment Nett Price</label>
                                                <input type="number" step="0.01" name="net_price" id="net_price"
                                                    class="form-control" value="{{$result->net_price}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="status">State</label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="PENDING" @if ($result->status == "PENDING")
                                                        {{ 'selected' }}
                                                        @endif>PENDING</option>
                                                    <option value="UNCONFIRMED" @if ($result->status == "UNCONFIRMED")
                                                        {{ 'selected' }}
                                                        @endif>UNCONFIRMED</option>
                                                    <option value="CONFIRMED" @if ($result->status == "CONFIRMED")
                                                        {{ 'selected' }}
                                                        @endif>CONFIRMED</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{url('/consumption')}}" type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</a>
                                    <button type="submit" class="btn btn-warning">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    @endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#code_quotation').keyup(function(){
                var query = $(this).val();
                if(query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.quotation') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#code_quotationlist').fadeIn();
                                $('#code_quotationlist').html(data);
                            } else {
                                $('#code_quotationlist').fadeOut();
                                $('#code_quotationlist').empty();
                                $('#code_quotation').val('');
                            }
                        }
                    });
                }
            });
        });

        function pilihQuotation($ls){
            var ls = $ls;
            var ls = $ls;
            $('#code_quotation').val($('#code_quo'+ls).text());
            $('#code_quotationlist').fadeOut();

            var query = document.getElementById("code_quotation").value;
            var _token = $('input[name="_token"').val();
            $.ajax({
            url:"{{route('salesorders.getquotation')}}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
                console.log(data);
                document.getElementById("customer").value = data.cust;
                document.getElementById("customer_style").value = data.style;
                document.getElementById("delivery_date").value = data.delivery;
                document.getElementById("references_date").value = data.tgl_quot;
                document.getElementById("net_price").value = data.totalcost_handling_margin;
                }
            });
        }

        $(document).ready(function(){
            $('#number_mp').keyup(function(){
                var query = $(this).val();
                if(query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.mcp') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#number_mcplist').fadeIn();
                                $('#number_mcplist').html(data);
                            } else {
                                $('#number_mcplist').fadeOut();
                                $('#number_mcplist').empty();
                                $('#number_mp').val('');
                            }
                        }
                    });
                }
            });

        });

        function pilihMcp($ls){
            var ls = $ls;
            var ls = $ls;
            $('#number_mp').val($('#number_mcp'+ls).text());
            $('#number_mcplist').fadeOut();

            // var query = document.getElementById("code_quotation").value;
            // var _token = $('input[name="_token"').val();
            // $.ajax({
            //     url:"{{route('salesorders.getquotation')}}",
            //     method:"POST",
            //     data:{query:query, _token:_token},
            //     success:function(data){

            //         console.log(data);
            //         document.getElementById("customer").value = data.cust;
            //         document.getElementById("customer_style").value = data.style;
            //         document.getElementById("delivery_date").value = data.delivery;
            //             document.getElementById("references_date").value = data.tgl_quot;
            //     }
            // });
        }
    </script>


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

    number=$('#number').val();

		$.ajax({
			url : '{{URL::to("/salesorders")}}?page=' + page,
			type : 'get',
			dataType: 'json',
			data:{'number' : number}
		}).done(function (data) {
			$('tbody').html(data);
			location.hash = page;
		}).fail(function (msg) {
			alert('Gagal menampilkan data, silahkan refresh halaman.');
		});
	}

    </script>
