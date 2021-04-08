@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salesorders') }}">Master Sales Order</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/so_assortment') }}/{{$getsalesorder->id}}">Assortment</a></li>
        <li class="breadcrumb-item active">Edit Data Assortment</a></li>
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
                    <form action="/so_assortment/update" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2">
                            <div class="modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Data Assortment</strong></h6>
                            </div>
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="id" value="{{$result->id}}">
                                                <label for="sample">Sample</label>
                                                <input type="hidden" name="id_sales_order" id="id_sales_order"
                                                    class="form-control" value="{{$result->id_sales_order}}" readonly>
                                                <input type="text" name="sample" id="sample" class="form-control"
                                                    value="{{$salesorder[0]['number']}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="color">Color</label>
                                                <input type="hidden" id="code_color" type="text"
                                                    class="form-control @error('code_color') is-invalid @enderror"
                                                    name="code_color" value="{{ $result->id_color }}" required
                                                    autocomplete="off">
                                                <input id="color" type="text"
                                                    class="form-control @error('color') is-invalid @enderror"
                                                    name="color" value="{{ $result->color['name'] }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="code_colorlist"></div>
                                                </span>

                                                @error('code_color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="size">Size</label>
                                                <input type="hidden" id="code_size" type="text"
                                                    class="form-control @error('code_size') is-invalid @enderror"
                                                    name="code_size" value="{{ $result->id_size }}" required
                                                    autocomplete="off">
                                                <input id="size" type="text"
                                                    class="form-control @error('size') is-invalid @enderror" name="size"
                                                    value="{{ $result->sizes['name'] }}" required autocomplete="off">
                                                <span>
                                                    <div id="code_sizelist"></div>
                                                </span>

                                                @error('code_size')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="quantity">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control"
                                                    value="{{$result->quantity}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="tolerance">Tolerance</label>
                                                <input type="number" name="tolerance" id="tolerance"
                                                    class="form-control" value="{{$result->tolerance}}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="/so_assortment/{{$result->id_sales_order}}" type="button"
                                    class="btn btn-default">Close</a></button>
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
                    $('#color').keyup(function(){
                        var query = $(this).val();
                        if(query != '')
                        {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                            url:"{{ route('autocomplete.color') }}",
                            method:"POST",
                            data:{query:query, _token:_token},
                            success:function(data){
                                if (data!='') {
                                    $('#code_colorlist').fadeIn();
                                    $('#code_colorlist').html(data);
                                    } else {
                                    $('#code_colorlist').fadeOut();
                                    $('#code_colorlist').empty();
                                    $('#code_color').val('');
                                    $('#color').val('');
                                    }
                                }
                            });
                        }
                    });
                    $('#size').keyup(function(){
                        var query = $(this).val();
                        if(query != '')
                        {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                            url:"{{ route('autocomplete.size') }}",
                            method:"POST",
                            data:{query:query, _token:_token},
                            success:function(data){
                                if (data!='') {
                                    $('#code_sizelist').fadeIn();
                                    $('#code_sizelist').html(data);
                                    } else {
                                    $('#code_sizelist').fadeOut();
                                    $('#code_sizelist').empty();
                                    $('#code_size').val('');
                                    $('#size').val('');
                                    }
                                }
                            });
                        }
                    });
                });

            function pilihColor($ls){
            var ls = $ls;
            var ls = $ls;
            $('#code_color').val($('#code_col'+ls).text());
            $('#color').val($('#col'+ls).text());
            $('#code_colorlist').fadeOut();
            }
            function pilihSize($ls){
            var ls = $ls;
            var ls = $ls;
            $('#code_size').val($('#code_siz'+ls).text());
            $('#size').val($('#siz'+ls).text());
            $('#code_sizelist').fadeOut();
            }
    </script>
