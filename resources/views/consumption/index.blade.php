@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Consumption</li>
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
            Master Consumption
        </div>
        <div class="card-body">
            <div align="right">
                <a href="#" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    New Data</a>
            </div>
            <br>

            <div class="table-responsivee">
                <table class="table table-bordered table-striped table-hover">

                    <thead>
                        <tr class="card-header">
                            <th>Number</th>
                            <th>Sales Order Number</th>
                            <th>Customer</th>
                            <th>Customer Style</th>
                            <th>Delivery Date</th>
                            <th>Quotation Number</th>
                            <th>Status</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" name="search_id" id="search_id">
                                <input type="text" class="form-control" onkeyup="getDatas('')"
                                    style="max-width: 180 !important;" placeholder="RKK Number" id="search_code"
                                    autocomplete="off">
                            </td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" onkeyup="getDatas('')"
                                    style="max-width: 180 !important;" placeholder="Customer" id="search_customer"
                                    autocomplete="off">
                            </td>
                            <td>
                                <input type="text" class="form-control" onkeyup="getDatas('')"
                                    style="max-width: 180 !important;" placeholder="Style" id="search_customer_style"
                                    autocomplete="off">
                            </td>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" onkeyup="getDatas('')"
                                    style="max-width: 180 !important;" placeholder="Quotation"
                                    id="search_code_quotation" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                        @include('consumption.list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/consumption/create" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Data Consumption</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="code_quotation">Quotation Code</label>
                                    {{-- <input type="hidden" id="code_quotation" type="text"
                                        class="form-control @error('code_quotation') is-invalid @enderror"
                                        name="code_quotation" value="{{ old('code_quotation') }}" required
                                    autocomplete="off"> --}}
                                    <input id="code_quotation" type="text"
                                        class="form-control @error('code_quotation') is-invalid @enderror"
                                        name="code_quotation" value="{{ old('code_quotation') }}" required
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
                                    <label for="customer">Customer</label>
                                    <input id="customer" type="text"
                                        class="form-control @error('customer') is-invalid @enderror" name="customer"
                                        value="{{ old('customer') }}" required autocomplete="off">
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
                                    <label for="customer_style">Customer Style</label>
                                    <input id="customer_style" type="text"
                                        class="form-control @error('customer_style') is-invalid @enderror"
                                        name="customer_style" value="{{ old('customer_style') }}" required
                                        autocomplete="off">
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
                                    <input type="text" name="number_mp" id="number_mp" class="form-control" placeholder="" value="" required autocomplete="off">
                                    <span>
                                        <div id="number_mcplist"></div>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="size_tengah">Size Tengah</label>
                                    <input type="text" name="size_tengah" class="form-control" placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="delivery_date">Delivery Date</label>
                                    <input type="date" name="delivery_date" id="delivery_date" class="form-control"
                                        placeholder="" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="references_date">References Date</label>
                                    <input type="date" name="references_date" id="references_date" class="form-control"
                                        placeholder="" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="net_price">Garment Nett Price</label>
                                    <input type="number" step="0.1" name="net_price" id="net_price" class="form-control" value="" required>
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
        <div id="modal_edit{{ $q->id }}" class="modal fade">
            <div class="modal-dialog">
                <form action="/marker/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit Data Marker</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="id" class="form-control" style="text-transform:uppercase"
                                        placeholder="Kode Marker" value="{{$q->id}}" required readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="nama_marker" class="form-control"
                                        placeholder="Nama Currencies" value="{{$q->nama_marker}}" autofocus required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="style" class="form-control" placeholder="Style"
                                        value="{{$q->style}}" required>
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

        function getDatas(page)
        {
        id=$('#search_id').val();
        code=$('#search_code').val();
        so_number=$('#search_so_number').val();
        customer=$('#search_customer').val();
        customer_style=$('#search_customer_style').val();
        code_quotation=$('#search_code_quotation').val();

            $.ajax({
                url : '{{URL::to("/consumption")}}?page=' + page,
                type : 'get',
                dataType: 'json',
                data:{'id':id,'code':code,'so_number':so_number, 'customer':customer, 'customer_style':customer_style,'code_quotation':code_quotation}
            }).done(function (data) {
                $('tbody').html(data);
                location.hash = page;
            }).fail(function (msg) {
                // alert('Gagal menampilkan data, silahkan refresh halaman.');
            });
        }

    </script>
