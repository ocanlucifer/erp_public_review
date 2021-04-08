@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salesorders') }}">Master Sales Order</a></li>
        <li class="breadcrumb-item active">Size Spec</a></li>
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

    <?php $id = Request::segment(3); ?>
    <input type="hidden" name="id" value="{{$id}}">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="/so_assortment/{{$id}}">Assortment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/salesorders/sizespecs/{{$id}}">Size Specs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salesorders/remark/{{$id}}">Remark</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salesorders/materialrequirements/{{$id}}">Material
                                Requirements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salesorders/image/{{$id}}">Images</a>
                        </li>
                    </ul>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="container">

                                <table class="table table-bordered table-striped table-hover table-responsive">
                                    <thead>
                                        <tr class="">
                                            <th>No</th>
                                            <th>Pos</th>
                                            <th>Specification</th>
                                            <th>Unit</th>
                                            <th>Allowance</th>
                                            <th>Size</th>
                                            <th>Value</th>
                                            <th></th>
                                        </tr>

                                        <?php $no=0;?>
                                        @foreach($sizespecs as $ss) :
                                        <?php $no++; ?>
                                        <tr class="text-center">
                                            {{ csrf_field() }}

                                            <td>{{$no}}</td>
                                            <td>{{$ss->position}}</td>
                                            <td>{{$ss->specification}}</td>
                                            <td>{{$ss->unit}}</td>
                                            <td>{{$ss->allowance}}</td>
                                            <td>{{$ss->sizes['name']}}</td>
                                            <td>{{$ss->value}}</td>
                                            <td>
                                                <a href="/salesorders/sizespecs/delete/{{ $ss->id }}"
                                                    onclick="return confirm('Hapus sample dengan no. {{ $ss->salessample['number'] }}, Lanjutkan?');"
                                                    class="btn btn-danger btn-xs tooltips" data-popup="tooltip"
                                                    data-original-title="Delete" data-placement="top"><i
                                                        class="icon-x"></i></a> &nbsp
                                                <a href="/salesorders/sizespecs/edit/{{ $ss->id }}"
                                                    class="btn btn-primary btn-xs tooltips" data-popup="tooltip"
                                                    data-original-title="Edit" data-placement="top"><i
                                                        class="icon-pencil"></i></a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </thead>
                                </table>


                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row ml-10">
            <div class="col-lg-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                    NEW
                </button>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/salesorders/sizespecs/new" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Input Size Spec</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="order">Order</label>
                                    <input type="hidden" name="id_sales_order" id="id_sales_order" class="form-control"
                                        value="{{$getsalesorder->id}}" readonly>

                                    <input type="text" name="order" id="order" class="form-control"
                                        value="{{$getsalesorder->number}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="size">Size</label>
                                    <input type="hidden" id="code_size" name="code_size" type="text"
                                        class="form-control @error('code_size') is-invalid @enderror"
                                        value="{{ old('code_size') }}" required autocomplete="off">
                                    <input id="size" type="text"
                                        class="form-control @error('size') is-invalid @enderror" name="size"
                                        value="{{ old('size') }}" required autocomplete="off">
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
                                    <label for="value">Quantity</label>
                                    <input type="number" name="value" id="value" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="specification">Specification</label>
                                    <input type="text" name="specification" id="specification" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="allowance">Allowance</label>
                                    <input type="text" name="allowance" id="allowance" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="position">Position</label>
                                    <input type="text" name="position" id="position" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="unit">Unit</label>
                                    <select name="unit" id="unit" class="form-control">
                                        <option value="cm">CM</option>
                                        <option value="inc">INC</option>
                                        <option value="null">null</option>
                                    </select>
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
