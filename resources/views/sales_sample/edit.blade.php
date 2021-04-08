@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salessamples') }}">Master Sales Sample</a></li>
        <li class="breadcrumb-item active">Edit Data Sample</a></li>
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
                    <form action="/salessamples/update" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Sample</strong></h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{$result->id}}">
                                                <label for="number">Number</label>
                                                <input type="text" name="number" id="number" class="form-control"
                                                    placeholder="Number" value="{{$result->number}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="order_date">Order Date</label>
                                                <input type="date" name="order_date" id="order_date"
                                                    class="form-control" value="{{$result->order_date}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="delivery_date">Delivery Date</label>
                                                <input type="date" name="delivery_date" id="delivery_date"
                                                    class="form-control" value="{{$result->delivery_date}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="customer">Customer</label>
                                                {{-- <input type="hidden" id="code_customer" type="text"
                                                    class="form-control @error('code_customer') is-invalid @enderror"
                                                    name="code_customer" value="{{ $result->id_customer }}" required
                                                autocomplete="off"> --}}
                                                <input id="customer" type="text"
                                                    class="form-control @error('customer') is-invalid @enderror"
                                                    name="customer" value="{{ $result->customer }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="code_customerlist"></div>
                                                </span>

                                                @error('code_customer')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="number">Agent</label>
                                                <input type="text" name="agent" id="agent" class="form-control"
                                                    value="{{$result->agent}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="style">Style</label>
                                                {{-- <input type="hidden" id="id_style" type="text"
                                                    class="form-control @error('id_style') is-invalid @enderror"
                                                    name="id_style" value="{{$result->id_style}}" required
                                                autocomplete="off"> --}}
                                                <input id="style" type="text"
                                                    class="form-control @error('style') is-invalid @enderror"
                                                    name="style" value="{{$result->style}}" required autocomplete="off">
                                                <span>
                                                    <div id="stylelist"></div>
                                                </span>

                                                @error('style')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="art_number">Art Number</label>
                                                <input type="text" name="art_number" id="art_number"
                                                    class="form-control" value="{{$result->art_number}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="brand">Brand</label>
                                                {{-- <input type="hidden" id="id_brand" type="text"
                                                    class="form-control @error('id_brand') is-invalid @enderror"
                                                    name="id_brand" value="{{$result->id_brand}}" required
                                                autocomplete="off"> --}}
                                                <input id="brand" type="text"
                                                    class="form-control @error('brand') is-invalid @enderror"
                                                    name="brand" value="{{$result->brand}}" required autocomplete="off">
                                                <span>
                                                    <div id="brandlist"></div>
                                                </span>

                                                @error('brand')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="season">Season</label>
                                                <input type="text" name="season" id="season" class="form-control"
                                                    value="{{$result->season}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="garment_type">Garment Type</label>
                                                {{-- <input type="hidden" id="id_garment_type" type="text"
                                                    class="form-control @error('id_garment_type') is-invalid @enderror"
                                                    name="id_garment_type" value="{{$result->stylesample['tipe']}}"
                                                required autocomplete="off"> --}}
                                                <input id="garment_type" type="text"
                                                    class="form-control @error('garment_type') is-invalid @enderror"
                                                    name="garment_type" value="{{ $result->garment_type }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="garment_typelist"></div>
                                                </span>

                                                @error('garment_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="style_group">Style Group</label>
                                                <select class="form-control" name="style_group" id="style_group"
                                                    required>
                                                    <option value="basic" @if ($result->style_group == "basic")
                                                        echo selected
                                                        @endif>Basic</option>
                                                    <option value="complicated" @if ($result->style_group ==
                                                        "complicated")
                                                        echo selected
                                                        @endif>Complicated</option>
                                                    <option value="medium" @if ($result->style_group == "medium")
                                                        echo selected
                                                        @endif>Medium</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="sample_type">Sample Type</label>
                                                {{-- <input type="hidden" id="id_sample_t" type="text"
                                                    class="form-control @error('id_sample_t') is-invalid @enderror"
                                                    name="id_sample_t" value="{{ $result->stylesample['id'] }}"
                                                required
                                                autocomplete="off"> --}}
                                                <input id="sample_type" type="text"
                                                    class="form-control @error('sample_type') is-invalid @enderror"
                                                    name="sample_type" value="{{ $result->sample_type}}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="sample_typelist"></div>
                                                </span>

                                                @error('sample_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="cust_style_name">Customer Style Name</label>
                                                <input type="text" name="cust_style_name" id="cust_style_name"
                                                    class="form-control" value="{{$result->cust_style_name}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description"
                                                rows="3">{{$result->description}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="revision_note">Revision Note</label>
                                            <textarea class="form-control" name="revision_note" id="revision_note"
                                                rows="3">{{$result->revision_note}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{$result->id}}">
                                                <label for="state">State</label>
                                                <select class="form-control" name="state" id="state" required>
                                                    <option value="pending" @if ($result->state == "pending")
                                                        {{ 'selected' }}
                                                        @endif>Pending</option>
                                                    <option value="unconfirmed" @if ($result->state == "unconfirmed")
                                                        {{ 'selected' }}
                                                        @endif>Unconfirmed
                                                    </option>
                                                    <option value="confirmed" @if ($result->state == "confirmed")
                                                        {{ 'selected' }}
                                                        @endif>Confirmed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="/salessamples" type="button" class="btn btn-default">Close</a></button>
                                <button type="submit" class="btn btn-warning">Submit</button>
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
                $('#quotation').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
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
                                $('#quotation').val('');
                                }
                            }
                        });
                    }
                });
                $('#customer').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.customer') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#code_customerlist').fadeIn();
                                $('#code_customerlist').html(data);
                                } else {
                                $('#code_customerlist').fadeOut();
                                $('#code_customerlist').empty();
                                $('#code_customer').val('');
                                $('#customer').val('');
                                }
                            }
                        });
                    }
                });
               $('#style').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.style') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#stylelist').fadeIn();
                                $('#stylelist').html(data);
                                } else {
                                $('#stylelist').fadeOut();
                                $('#stylelist').empty();
                                $('#style').val('');
                                $('#style').val('');
                                }
                            }
                        });
                    }
                });
                $('#brand').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.brand') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#brandlist').fadeIn();
                                $('#brandlist').html(data);
                                } else {
                                $('#brandlist').fadeOut();
                                $('#brandlist').empty();
                                $('#brand').val('');
                                $('#brand').val('');
                                }
                            }
                        });
                    }
                });

                $('#sample_type').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.sample_type') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#sample_typelist').fadeIn();
                                $('#sample_typelist').html(data);
                                } else {
                                $('#sample_typelist').fadeOut();
                                $('#sample_typelist').empty();
                                $('#sample_type').val('');
                                }
                            }
                        });
                    }
                });

                $('#garment_type').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                        url:"{{ route('autocomplete.garment_type') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            if (data!='') {
                                $('#garment_typelist').fadeIn();
                                $('#garment_typelist').html(data);
                                } else {
                                $('#garment_typelist').fadeOut();
                                $('#garment_typelist').empty();
                                $('#garment_type').val('');
                                $('#garment_type').val('');
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
                $('#quotation').val($('#quo'+ls).text());
                $('#code_quotationlist').fadeOut();
            }

            function pilihCustomer($ls){
                var ls = $ls;
                var ls = $ls;
                $('#code_customer').val($('#code_cust'+ls).text());
                $('#customer').val($('#cust'+ls).text());
                $('#code_customerlist').fadeOut();
            }

            function pilihStyle($ls){
                var ls = $ls;
                var ls = $ls;
                $('#style').val($('#id_sty'+ls).text());
                $('#style').val($('#sty'+ls).text());
                $('#stylelist').fadeOut();
            }

            function pilihBrand($ls){
                var ls = $ls;
                var ls = $ls;
                $('#brand').val($('#id_br'+ls).text());
                $('#brand').val($('#br'+ls).text());
                $('#brandlist').fadeOut();
            }

            function pilihSample_type($ls){
                var ls = $ls;
                var ls = $ls;
                $('#sample_type').val($('#id_smpt'+ls).text());
                $('#sample_type').val($('#smpt'+ls).text());
                $('#sample_typelist').fadeOut();
            }

            function pilihGarmentType($ls){
                var ls = $ls;
                var ls = $ls;
                $('#garment_type').val($('#id_gar_type'+ls).text());
                $('#garment_type').val($('#gar_type'+ls).text());
                $('#garment_typelist').fadeOut();
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
