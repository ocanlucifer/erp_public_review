@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="" id="container">

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
                            <a class="nav-link" href="/salesorders/sizespecs/{{$id}}">Size Specs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/salesorders/remark/{{$id}}">Remark</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salesorders/materialrequirements/{{$id}}">Material
                                Requirements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/salesorders/image/{{$id}}">Images</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ($remark2 > 0) {
            $action = '/salesorders/remark/update/' . $id;
        } else {
            $action = '/salesorders/remark/new/' . $id;
        }
        ?>

        <form action="{{$action}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-12">

                    @foreach ($remarktype as $rt)
                    <a class="mr-5" href="#remark-{{$rt->name}}">{{$rt->name}} | </a>
                    @endforeach

                </div>
            </div>

            <div class="row mt-2">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary" id="btn-save" style="width: 30vh;">Save</button>
                </div>
            </div>

            <?php $no = 0; ?>
            @foreach ($remarktype as $rt)

            <h3 class="text-uppercase" id="remark-{{$rt->name}}">{{$rt->name}}</h3>
            <div class="row">
                <?php if($remark2 > 0) { ?>
                <input type="hidden" name="id{{$no}}" id="id" value="{{$remark[$no]['id']}}">
                <?php } ?>
                <div class="col-sm-12">

                    <textarea name="description{{$no}}" id="fabric" cols="60" rows="10">
                    <?php if($remark2 > 0) { ?>
                        {{$remark[$no]['description']}}
                    <?php } ?>
                    </textarea>
                    <a href="#container">Lanjutkan</a>
                </div>
            </div>
            <?php $no++; ?>
            @endforeach

        </form>

    </div>

    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
