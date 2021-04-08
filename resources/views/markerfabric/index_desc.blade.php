@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/marker') }}">Master Marker</a></li>
        <li class="breadcrumb-item">Marker fabric</a></li>
        <li class="breadcrumb-item active">Marker Description</li>
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
            Marker Description ({{$markerfab->description}})
        </div>
        <div class="card-body">
            <div align="right">
                <a href="" data-toggle="modal" data-target="#modal" class="btn btn-primary"><i class="icon-pencil"></i>
                    Tambah Data Baru</a>
            </div>
            <br>

            <table class="table table-bordered table-striped table-hover table-responsive">

                <thead>
                    <tr class="card-header">
                        <th>No.</th>
                        <th>Width</th>
                        <th>Quantity</th>
                        <th>Gramasi: {{$markerfab->gramasi}}
                            <p>Consumption</p>
                        </th>
                        <th>Unit: {{$markerfab->unit}}
                            <p>Efficiency</p>
                        </th>
                        <th>Quantity Per Unit</th>
                        <th>Actual Per Unit</th>
                        <th>
                            <center>#</center>
                        </th>
                    </tr>
                </thead>
                <tbody id="view">
                    @include('markerfabric.list_desc')
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog">
                <form action="/markerdesc/new" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Data Marker Description</strong></h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" class="form-control" value="">
                            <input type="hidden" name="markerfab_id" class="form-control" value="{{$markerfab->id}}">

                            <div class="form-group">
                                <div class="input-group">
                                    <label for="width">Width</label>
                                    <input class="form-control" type="number" step="0.01" name="width" id="width"
                                        placeholder="width (must be numbers)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" step="0.01" name="quantity" class="form-control"
                                        placeholder="quantity (must be numbers)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="consumption">Consumption</label>
                                    <input type="number" step="0.01" name="consumption" class="form-control"
                                        placeholder="consumption (must be numbers)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="efficiency">Efficiency</label>
                                    <input type="number" step="0.01" name="efficiency" class="form-control"
                                        placeholder="efficiency (must be numbers)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="qty_unit">Quantity Per Unit</label>
                                    <input type="number" step="0.01" name="qty_unit" class="form-control"
                                        placeholder="quantity per unit (must be numbers)" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="act_unit">Actual Per Unit</label>
                                    <input type="number" step="0.01" name="act_unit" class="form-control"
                                        placeholder="actual per unit (must be numbers)" value="" required>
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
                <form action="/markerdesc/update" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2">
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit Data Marker Description</strong></h6>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" class="form-control" value="{{$q->id}}">
                            <input type="hidden" name="markerfab_id" class="form-control" value="{{$q->markerfab_id}}">

                            <div class="form-group">
                                <div class="input-group">
                                    <label for="width">Width</label>
                                    <input class="form-control" type="number" step="0.01" name="width" id="width"
                                        placeholder="width (must be numbers)" value="{{$q->width}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" step="0.01" name="quantity" class="form-control"
                                        placeholder="quantity (must be numbers)" value="{{$q->quantity}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="consumption">Consumption</label>
                                    <input type="number" step="0.01" name="consumption" class="form-control"
                                        placeholder="consumption (must be numbers)" value="{{$q->consumption}}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="efficiency">Efficiency</label>
                                    <input type="number" step="0.01" name="efficiency" class="form-control"
                                        placeholder="efficiency (must be numbers)" value="{{$q->efficiency}}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="qty_unit">Quantity Per Unit</label>
                                    <input type="number" step="0.01" name="qty_unit" class="form-control"
                                        placeholder="quantity per unit (must be numbers)" value="{{$q->qty_unit}}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="act_unit">Actual Per Unit</label>
                                    <input type="number" step="0.01" name="act_unit" class="form-control"
                                        placeholder="actual per unit (must be numbers)" value="{{$q->act_unit}}"
                                        required>
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
			var url = $(this).attr('href');
			getDatas($(this).attr('href').split('page=')[1]);
			e.preventDefault();
		});
    });
    </script>
