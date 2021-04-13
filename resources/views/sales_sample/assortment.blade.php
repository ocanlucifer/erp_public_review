@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/salessamples') }}">Master Sales Sample</a></li>
        <li class="breadcrumb-item active">Assortment</a></li>
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

    <?php $id = Requests::segment(2); ?>
    <input type="hidden" name="id" value="{{$id}}">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="/assortment/{{$id}}">Assortment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/sizespecs/{{$id}}">Size Specs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/remark/{{$id}}">Remark</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/materialrequirements/{{$id}}">Material
                                Requirements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salessamples/image/{{$id}}">Images</a>
                        </li>
                    </ul>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="container">

                                <table class="table table-bordered table-striped table-hover table-responsive">
                                    <thead>
                                        <tr class="">
                                            <th>No</th>
                                            <th>Sample</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Tolerance</th>
                                            <th>Action</th>
                                        </tr>

                                        <?php $no=0;?>
                                        @foreach($assortment as $as) :
                                        <?php $no++; ?>
                                        <tr class="">
                                            {{ csrf_field() }}

                                            <td>{{$no}}</td>
                                            <td>{{$as->salessample['number']}}</td>
                                            <td>{{$as->color['name']}}</td>
                                            <td>{{$as->sizes['name']}}</td>
                                            <td>{{$as->quantity}}</td>
                                            <td>{{$as->tolerance}}</td>
                                            <td>
                                                <a href="/assortment/delete/{{ $as->id }}"
                                                    onclick="return confirm('Hapus sample dengan no. {{ $as->salessample['number'] }}, Lanjutkan?');"
                                                    class="btn btn-danger btn-xs tooltips" data-popup="tooltip"
                                                    data-original-title="Delete" data-placement="top"><i
                                                        class="icon-x"></i></a> &nbsp
                                                <a href="/assortment/edit/{{ $as->id }}"
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
                {{-- <a href="/asortment/new" class="btn btn-primary" data-popup="tooltip" data-original-title="Edit"
                    data-placement="top">NEW</a> --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                    NEW
                </button>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="/assortment/new" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Input Assortment</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="sample">Sample</label>
                                    <input type="hidden" name="id_sales_sample" id="id_sales_sample"
                                        class="form-control" value="{{$getsalessample->id}}" readonly>
                                    <input type="text" name="sample" id="sample" class="form-control"
                                        value="{{$getsalessample->number}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="color">Color</label>
                                    <input type="hidden" id="code_color" type="text"
                                        class="form-control @error('code_color') is-invalid @enderror" name="code_color"
                                        value="{{ old('code_color') }}" required autocomplete="off">
                                    <input id="color" type="text"
                                        class="form-control @error('color') is-invalid @enderror" name="color"
                                        value="{{ old('color') }}" required autocomplete="off">
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
                                        class="form-control @error('code_size') is-invalid @enderror" name="code_size"
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
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="tolerance">Tolerance</label>
                                    <input type="number" name="tolerance" id="tolerance" class="form-control" required>
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
