@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/salesorders')}}">Marker Check Production</a></li>
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

                    <form action="/mcp/update_ws/" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-content" id="background-body2" style="width:100% !important;">
                            <div class=" modal-header bg-indigo-600">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h6 class="modal-title"><strong>Edit Worksheet</strong></h6>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id" value="{{$mcpwsm->id}}">
                                            <input type="hidden" name="mcp" id="mcp" value="{{$mcpwsm->mcp}}">
                                            <div class="input-group">
                                                <label for="no_urut">No Urut</label>
                                                <input id="no_urut" type="number"
                                                    class="form-control @error('no_urut') is-invalid @enderror"
                                                    name="no_urut" value="{{ $mcpwsm->no_urut }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="color">Combo</label>
                                                <input id="color" type="text"
                                                    class="form-control @error('color') is-invalid @enderror"
                                                    name="color" value="{{ $mcpwsm->combo }}" required
                                                    autocomplete="off">
                                                <span>
                                                    <div id="colorlist"></div>
                                                </span>

                                                @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $mcpwsm->message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label for="qty_tot">Total WS Quantity</label>
                                                <input id="ws_qty_tot" type="number" value="0"
                                                    class="form-control @error('ws_qty_tot') is-invalid @enderror"
                                                    name="ws_qty_tot" value="{{ $mcpwsm->total_qty }}" readonly
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <table class="tabel table-hover table-responsivee" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 22%">Size</th>
                                                    <th style="width: 22%">Ws Quantity</th>
                                                    <th style="width: 22%">Tolerance</th>
                                                    <th style="width: 22%">Quantity</th>
                                                    <th style="width: 12%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="ws_tbody">
                                                <?php $count = 0; ?>
                                                @foreach ($mcpws as $ws)
                                                <?php $count++; ?>
                                                <tr>
                                                    <td><input class="form-control" type="text" name="input_size[]"
                                                            id="input_size_<?=$count;?>" value="{{$ws->size}}"></td>
                                                    <td><input class="form-control" type="number" name="input_ws_qty[]"
                                                            id="input_ws_qty_<?=$count;?>" value="{{$ws->ws_qty}}">
                                                    </td>
                                                    <td><input class="form-control" type="number"
                                                            name="input_tolerance[]" id="input_tolerance_<?=$count;?>"
                                                            value="{{$ws->tolerance}}"></td>
                                                    <td><input class="form-control" type="number" name="input_qty_tot[]"
                                                            id="input_qty_tot_<?=$count;?>" value="{{$ws->qty_tot}}"
                                                            readonly>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @endforeach
                                                <input type="hidden" name="count" id="count" value="<?=$count; ?>">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input class="btn btn-sm btn-primary" type="submit" id="submit" disabled>
                                        <button class="btn btn-sm btn-warning" type="button" id="ws_calculate"
                                            onclick="calculate()">Calculate</button>
                                        <button class="btn btn-sm btn-success" type="button" id="ws_addrow"
                                            onclick="ms_addrow()">Add Row</button>
                                        <a href="/mcp/detail/{{$mcp}}" class="btn btn-sm btn-primary">Kembali</a>
                                    </div>
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
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>

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
        $('#colorlist').fadeIn();
        $('#colorlist').html(data);
        } else {
        $('#colorlist').fadeOut();
        $('#colorlist').empty();
        $('#color').val('');
        }
        }
        });
        }
        });

    });
        function pilihColor($ls){
        var ls = $ls;
        var ls = $ls;
        $('#color').val($('#col'+ls).text());
        $('#colorlist').fadeOut();
        }

    </script>

    <script type="text/javascript">
        // MCP WORKSHEET
        function ms_addrow(){
            var count = document.getElementById("count").value;
            count++;
            document.getElementById("count").value=count;
            baris = '<tr>'+
            '<td>'+'<input class="form-control" type="text" name="input_size[]" id="input_size_'+count+'">'+'</td>'+
                '<td>'+'<input class="form-control" type="number" name="input_ws_qty[]" id="input_ws_qty_'+count+'">'+'</td>'+
                '<td>'+'<input class="form-control" type="number" name="input_tolerance[]" id="input_tolerance_'+count+'">'+'</td>'+
                '<td>'+'<input class="form-control" type="number" name="input_qty_tot[]" id="input_qty_tot_'+count+'" readonly>'+'</td>'+
                '<td>'+'<button class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove();">X</button>'+'</td>' +
            '</tr>'
            $('#ws_tbody').append(baris);

        }

        $('#click_create').click(function(){
            $('#submit').prop('disabled',true);
        });

        function calculate(){
            var ws_qty_tot = 0
            var count = document.getElementById("count").value;
            for (i=1; i<=count; i++){
            console.log('ok');
                var ws_qty = document.getElementById('input_ws_qty_' + i).value;
                var tolerance = document.getElementById('input_tolerance_' + i).value;

                var tolerance_val = ws_qty * tolerance * 0.01;
                var tolerance_round = Math.round(tolerance_val);

                var qty_tot = parseInt(ws_qty) + parseInt(tolerance_round);
                $('#input_qty_tot_'+i).val(qty_tot);

                ws_qty_tot = parseInt(ws_qty_tot) + parseInt(qty_tot);
            }
                $('#ws_qty_tot').val(ws_qty_tot);

            $('#submit').prop('disabled',false);
        }
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

    </script>
