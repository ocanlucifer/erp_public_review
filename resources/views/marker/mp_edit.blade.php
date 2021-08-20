@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/mp')}}">Production Marker</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/mp/detail/'.$result->id)}}">Marker</a></li>
        <li class="breadcrumb-item active">Edit MCP</li>
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

                    <form action="/mp/update" method="post" enctype='multipart/form-data'>
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
                                                <label for="number">Number</label>
                                                <input type="text" name="number" id="number"
                                                    class="form-control bg-warning" placeholder="Number"
                                                    value="{{$result->number}}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="order_name">Oder Name</label>
                                                <input id="order_name" type="text"
                                                    class="form-control @error('order_name') is-invalid @enderror"
                                                    name="order_name" value="{{ $result->order_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="{{url('/mp/detail/'.$result->id)}}" type="button" class="btn btn-default"
                                    data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-warning">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
