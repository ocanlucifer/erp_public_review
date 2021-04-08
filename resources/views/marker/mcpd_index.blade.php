@extends('layouts.app')

@section('content')

<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/mcp')}}">Marker Check Production</a></li>
        <li class="breadcrumb-item active">Detail</li>
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
            Marker Check Production
        </div>
        <div class="card-body text-size-small">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Number</b></div>
                    <div class="col-sm-8">: {{$mcp->number}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Delivery Date</b></div>
                    <div class="col-sm-8">: {{date('d-m-Y', strtotime($mcp->delivery_date))}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Created By</b></div>
                    <div class="col-sm-8">: {{$mcp->created_by}}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Order Name</b></div>
                    <div class="col-sm-8">: {{$mcp->order_name}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Fabric Construct</b></div>
                    <div class="col-sm-8">: {{$mcp->fabric_const}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Updated By</b></div>
                    <div class="col-sm-8">: {{$mcp->updated_by}}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Style Name</b></div>
                    <div class="col-sm-8">: {{$mcp->style}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Fabric Compost</b></div>
                    <div class="col-sm-8">: {{$mcp->fabric_comp}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>
                            @if ($mcp->state == 'PENDING' || $mcp->state == 'CONFIRMED')
                            Confirmed By
                            @elseif ($mcp->state == 'UNCONFIRMED')
                            Unconfirmed By
                            @endif
                        </b></div>
                    <div class="col-sm-8">: {{$mcp->confirmed_by}}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Revisi</b></div>
                    <div class="col-sm-8">: {{$mcp->revision_count}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Sales Order Number</b></div>
                    <div class="col-sm-8">: </div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b></b></div>
                    <div class="col-sm-8"></div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Revisi Remark</b></div>
                    <div class="col-sm-8">: {{$mcp->revisi_remark}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>State</b></div>
                    <div class="col-sm-8">: {{$mcp->state}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b></b></div>
                    <div class="col-sm-8"></div>
                </div>
            </div>

            <div class="mt-3">
                <a href="/mcp" class="btn btn-secondary btn-sm">Back</a>
                @if ($mcp->state == "PENDING" || $mcp->state == "UNCONFIRMED")
                <a href="/mcp/edit/{{$mcp->id}}" class="btn btn-primary btn-sm">Edit</a>
                <a href="#" id="click_create" data-toggle="modal" data-target="#modal"
                    class="btn btn-success btn-sm">Create Worksheet</a>
                <a href="/mcp/confirm/{{$mcp->id}}/1" class="btn btn-warning btn-sm"
                    onclick="return confirm('Anda yakin untuk konfirmasi?')">Confirm</a>
                @else
                <a href="#" id="" class="btn btn-primary btn-sm">Export to Marker Production</a>
                <a href="/mcp/confirm/{{$mcp->id}}/0" class="btn btn-danger btn-sm"
                    onclick="return confirm('Anda yakin untuk membatalkan konfirmasi?')">Unconfirm</a>


                @endif

                <a href="/mcp/print_rekkons/{{$mcp->id}}" target="_blank" class="btn btn-info btn-sm">Rekap Konsumsi</a>
                <a href="#" class="btn btn-info btn-sm">Rekap Piping</a>
            </div>
            <br>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            WORKSHEET
        </div>
        <div class="card-body text-size-small">
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header" style="background-color: #696969; color: #fff">
                            <th class="text-center">No.</th>
                            <th colspan="3">Combo</th>
                            <th colspan="3">Total Quantity</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <?php $qty_for_detail = 0; ?>
                        @foreach ($mcp_wsheet_m as $mcpwsm)
                        <tr style="background-color: #d3d3d3;">
                            <td class="text-center">{{$mcpwsm->no_urut}}</td>
                            <td colspan="3">{{$mcpwsm->combo}}</td>
                            <td colspan="3">{{$mcpwsm->total_qty}}</td>
                            <?php $qty_for_detail = $mcpwsm->total_qty; ?>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm->id}}">Print
                                            All</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_ws/{{$mcpwsm->id}}/{{$mcp->id}}">Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#form"
                                            data-wsheet="{{$mcpwsm->id}}" id="click_newtype" onclick="newtype()">New
                                            Type</a>
                                        <hr>
                                        <a class="dropdown-item" href="#">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="6">
                                <?php $mcpwsm_print = $mcpwsm->id ; ?>
                                <?php $size_qty = 'Size [Quantity] = '; ?>
                                <?php $size_for_detail = ''; ?>

                                @foreach ($mcp_wsheet as $mcpws)
                                <?php if ($mcpws['mcp_wsheet_m'] == $mcpwsm['id']) {
                                    $size_qty = $size_qty . $mcpws['size'] . ' [' . $mcpws['qty_tot'] . ']';
                                    $size_for_detail .= '['.$mcpws['size'].']';
                                } ?>
                                @endforeach
                                {{-- end foreach wsheet --}}
                                <?php if (strlen($size_qty) > 19 ) {
                                    echo $size_qty; } ?>
                            </td>
                        </tr>

                        @foreach ($mcp_type as $mcpt)
                        <?php if($mcpt['id_wsheet'] == $mcpwsm['id']) { ?>
                        <tr style="background-color: #696969; color: #fff">
                            <td></td>
                            <td colspan="7"><b>{{$mcpt->type}}</b></td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td></td>
                            <td>Jenis Kain</td>
                            <td>Warna</td>
                            <td>Komponen</td>
                            <td>Type</td>
                            <td>Destination</td>
                            <td colspan="2" class="text-center">Action</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$mcpt->no_urut}}. {{$mcpt->fabricconst}}</td>
                            <td>{{$mcpt->warna}}</td>
                            <td>{{$mcpt->component}}</td>
                            <td>{{$mcpt->type}}</td>
                            <td>{{$mcpt->tujuan}}</td>
                            <td colspan="2" class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Print Rekap Hitung</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpt/{{$mcpt->id}}/{{$mcp->id}}">Edit</a>
                                        <a class="dropdown-item click_newdetail" href="#" data-toggle="modal"
                                            data-target="#form-detail" data-detype="{{$mcpt->id}}"
                                            data-deqty="{{$qty_for_detail}}" data-desize="{{$size_for_detail}}"
                                            id="click_newdetail" onclick="newDetail()">New Detail
                                        </a>
                                        <hr>
                                        <a class="dropdown-item" href="#">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php foreach ($mcp_detail as $mcpd) { ?>
                        <?php if($mcpd['id_type'] == $mcpt['id']) { ?>
                        <tr>
                            <td colspan="2"></td>
                            <td><b>Marker ke</b></td>
                            <td><b>Code</b></td>
                            <td><b>Panjang</b></td>
                            <td><b>Lebar</b></td>
                            <td><b>Gramasi</b></td>
                            <td><b>Action</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td><a href="/mcp/show_detail/{{$mcpd->id}}/{{$mcp->id}}/{{$qty_for_detail}}/{{$size_for_detail}}"
                                    id="click_showdetail">M
                                    {{$mcpd->urutan}}</a>
                            </td>
                            <td>{{$mcpd->code}}</td>
                            <td>{{$mcpd->panjang_m}}</td>
                            <td>{{$mcpd->lebar_m}}(m),{{number_format((float)($mcpd->lebar_m * 39.37), 2, '.', '')}}(inc)
                            </td>
                            <td>{{$mcpd->gramasi}}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Print Detail</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$qty_for_detail}}/{{$size_for_detail}}">Edit</a>
                                        <hr>
                                        <a class="dropdown-item" href="#">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6"></td>
                            <td colspan="2" class="text-center">
                                <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}/{{$mcpd->id}}"
                                    target="_blank" class="btn btn-primary">Print Document</a>
                            </td>
                            {{-- <td colspan="2" class="text-center"><a
                                    href="{{ route('mcp.print_ws', ['mcp_id' => $mcp->id, '$mcpwsm_id' => $mcpwsm_print, 'mcpt_id' => $mcpt->id, 'mcpd_id' => $mcpd->id]) }}"
                            target="_blank" class="btn btn-primary">Print Document</a></td> --}}
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                        {{-- end if marker type = marker wsheet main --}}

                        @endforeach
                        {{-- end foreach type --}}


                        @endforeach
                        {{-- end foreach wsheet_main --}}

                    </tbody>
                    <tbody id="view">
                        {{-- @include('marker.mcp_list') --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- modal worksheet --}}
    <div class="row">
        <div id="modal" class="modal fade">
            <div class="modal-dialog modal-lg">

                <form action="/mcp/create_ws" method="post" enctype='multipart/form-data'>
                    {{ csrf_field() }}
                    <div class="modal-content" id="background-body2" style="width:120% !important;">
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Add Worksheet</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="hidden" name="mcp" id="mcp" value="{{$mcp->number}}">
                                        <div class="input-group">
                                            <label for="no_urut">No Urut</label>
                                            <input id="no_urut" type="number"
                                                class="form-control @error('no_urut') is-invalid @enderror"
                                                name="no_urut" value="{{ old('no_urut') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="color">Combo</label>
                                            <input id="color" type="text"
                                                class="form-control @error('color') is-invalid @enderror" name="color"
                                                value="{{ old('color') }}" required autocomplete="off">
                                            <span>
                                                <div id="colorlist"></div>
                                            </span>

                                            @error('color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="qty_tot">Total WS Quantity</label>
                                            <input id="ws_qty_tot" type="number" value="0"
                                                class="form-control @error('ws_qty_tot') is-invalid @enderror"
                                                name="ws_qty_tot" value="{{ old('ws_qty_tot') }}" readonly required>
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
                                            <tr>
                                                <td><input class="form-control" type="text" name="input_size[]"
                                                        id="input_size_1"></td>
                                                <td><input class="form-control" type="number" name="input_ws_qty[]"
                                                        id="input_ws_qty_1"></td>
                                                <td><input class="form-control" type="number" name="input_tolerance[]"
                                                        id="input_tolerance_1"></td>
                                                <td><input class="form-control" type="number" name="input_qty_tot[]"
                                                        id="input_qty_tot_1" readonly>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input class="btn btn-sm btn-primary" type="submit" id="submit" disabled>
                                    <button class="btn btn-sm btn-warning" type="button" id="ws_calculate"
                                        onclick="calculate()">Calculate</button>
                                    <button class="btn btn-sm btn-success float-right" type="button" id="ws_addrow"
                                        onclick="ms_addrow()">Add Row</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- modal type --}}
    <div class="modal fade" id="form" role="dialog">
        <div class="modal-dialog modal-lg">

            <form action="/mcp/create_type" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content" id="modal-content" style="width: 120%;">
                    <div class="modal-header">
                        <h3>New Types</h3>
                    </div>
                    <input type="hidden" name="mcp" id="mcp" value="{{$mcp->number}}">
                    <input type="hidden" name="id_wsheet" id="id_wsheet">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">No Urut</div>
                            <div class="col-sm-8"><input class="form-control" type="number" id="no_urut" name="no_urut"
                                    required></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Fab Description</div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="fabric_desc"
                                    id="fabric_desc">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Warna</div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="color_form" type="text"
                                        class="form-control @error('color_form') is-invalid @enderror" name="color_form"
                                        value="{{ old('color_form') }}" required autocomplete="off">
                                    <span>
                                        <div id="color_formlist"></div>
                                    </span>

                                    @error('color_form')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            {{ csrf_field() }}
                            <div class="col-sm-4 text-right">Type</div>
                            <div class="col-sm-8"><select class="form-control" name="type" id="type" required>
                                    <option value="" selected disabled>Pilih</option>
                                    <option value="aplikasi">Aplikasi</option>
                                    <option value="marker">Marker</option>
                                    <option value="kain keras">Kain Keras</option>
                                    <option value="Piping">Piping</option>
                                </select></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Component</div>
                            <div class="col-sm-8"><select class="form-control" name="component" id="component" required>
                                    <option value="" selected disabled>Pilih</option>
                                    <option value="body1">Body1</option>
                                    <option value="body2">Body2</option>
                                    <option value="body3">Body3</option>
                                    <option value="body4">Body4</option>
                                    <option value="body5">Body5</option>
                                    <option value="body6">Body6</option>
                                    <option value="body7">Body7</option>
                                    <option value="body8">Body8</option>
                                    <option value="body9">Body9</option>
                                    <option value="body10">Body10</option>
                                </select></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Tujuan</div>
                            <div class="col-sm-8"><input type="text" name="tujuan" id="tujuan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Fab Construct</div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    {{-- <input type="text" id="id_fabric_construct"
                                        class="form-control @error('id_fabric_construct') is-invalid @enderror"
                                        name="id_fabric_construct" value="{{ old('id_fabric_construct') }}" required
                                    autocomplete="off">
                                    <input id="fabric_construct" type="text"
                                        class="form-control @error('fabric_construct') is-invalid @enderror"
                                        name="fabric_construct" value="{{ old('fabric_construct') }}" required
                                        autocomplete="off">
                                    <span>
                                        <div id="fabric_constructlist"></div>
                                    </span>

                                    @error('fabric_construct')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                    <input type="hidden" id="id_fabricconst" type="text"
                                        class="form-control @error('id_fabricconst') is-invalid @enderror"
                                        name="id_fabricconst" value="{{ old('id_fabricconst') }}" required
                                        autocomplete="off">
                                    <input id="fabricconst" type="text"
                                        class="form-control @error('fabricconst') is-invalid @enderror"
                                        name="fabricconst" value="{{ old('fabricconst') }}" required autocomplete="off">
                                    <span>
                                        <div id="fabricconstlist"></div>
                                    </span>

                                    @error('fabricconst')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"></div>
                            <div class="col-sm-8"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Remark</div>
                            <div class="col-sm-8"><textarea class="form-control" name="remark" id="remark" cols="20"
                                    rows="2"></textarea></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right">Fab Compost</div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    {{-- <input id="fabric_compost" type="text"
                                        class="form-control @error('fabric_compost') is-invalid @enderror"
                                        name="fabric_compost" value="{{ old('fabric_compost') }}" required
                                    autocomplete="off">
                                    <span>
                                        <div id="fabric_compostlist"></div>
                                    </span>

                                    @error('fabric_compost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                    <input type="hidden" id="id_fabriccomp" type="text"
                                        class="form-control @error('id_fabriccomp') is-invalid @enderror"
                                        name="id_fabriccomp" value="{{ old('id_fabriccomp') }}" required
                                        autocomplete="off">
                                    <input id="fabriccomp" type="text"
                                        class="form-control @error('fabriccomp') is-invalid @enderror" name="fabriccomp"
                                        value="{{ old('fabriccomp') }}" required autocomplete="off">
                                    <span>
                                        <div id="fabriccomplist"></div>
                                    </span>

                                    @error('fabriccomp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row mb-10">
                        <div class="col-sm-4">
                            <input type="submit" id="submit_type" name="submit_type" class="btn btn-primary ml-10">
                            {{-- <button type="button" id="btn-ubah" onclick="ubahData()"
                                class="btn btn-primary">Ubah</button> --}}
                            <button type="button" data-dismiss="modal" class="btn btn-primary">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- modal detail --}}
    <div class="modal fade" id="form-detail" role="dialog">
        <div class="modal-dialog modal-lg">

            <form action="{{route('mcp.createdetail')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content" id="modal-content" style="width: 120%;">
                    <div class="modal-header">
                        <h3>New Detail</h3>
                    </div>
                    <input type="hidden" name="mcp" id="mcp" value="{{$mcp->number}}">
                    <input type="hidden" name="id_type" id="id_type">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Marker ke</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" id="urutan" name="urutan"
                                    required></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Code</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="code" id="code"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Marker Date</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="marker_date"
                                    id="marker_date">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="efisiensi"
                                    id="efisiensi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Perimeter</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="perimeter"
                                    id="perimeter">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>*Designer</b></small></div>
                            <div class="col-sm-8"><input class="form-control" name="designer" id="designer">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="tole_pjg_m" id="tole_pjg_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="tole_lbr_m" id="tole_lbr_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="kons_sz_tgh" id="kons_sz_tgh">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tgl Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="tgl_sz_tgh"
                                    id="tgl_sz_tgh">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="panjang_m"
                                    id="panjang_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                            <div class="col-sm-4"><input class="form-control" type="number" step="0.01" name="lebar_m"
                                    id="lebar_m">
                            </div>
                            <div class="col-sm-4"><input class="form-control" type="number" step="0.01" name="lebar_inc"
                                    id="lebar_inc" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="gramasi"
                                    id="gramasi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Total Skala</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="total_skala" id="total_skala">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain Yd/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="kons_yddz"
                                    d id="kons_yddz" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain Kg/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="kons_kgdz"
                                    d id="kons_kgdz" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain m/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="kons_mdz"
                                    id="kons_mdz" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Jumlah Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="jml_marker" id="jml_marker">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="jml_ampar"
                                    id="jml_ampar">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="file" name="pdf_marker"
                                    id="pdf_marker">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (yard)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="qty_yard"
                                    id="qty_yard" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (kg)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="qty_kg"
                                    id="qty_kg" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="qty_m"
                                    id="qty_m" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Ujiung Kain Yd</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                    name="ujungkain_yd" id="ujungkain_yd" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Ujiung Kain Kg</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01"
                                    name="ujungkain_kg" id="ujungkain_kg" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Ujiung Kain Mtr</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="ujungkain_m"
                                    id="ujungkain_m" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Komponen / Pcs</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="komponen" id="komponen">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revisi</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" name="revisi" id="revisi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revisi Remark</b></small></div>
                            <div class="col-sm-8"><textarea class="form-control" type="text" name="revisi_remark"
                                    id="revisi_remark"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-lg-1">
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="submit" id="submit_detail" name="submit_detail"
                                        class="btn btn-primary ml-10">
                                    <div class="col-sm-4">
                                    </div>
                                    <button type="button" data-dismiss="modal" class="btn btn-primary">Batal</button>
                                    <button class="btn btn-sm btn-warning" type="button" id="ws_calculate"
                                        onclick="calculate_d()">Calculate</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-lg-5">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Qty Ws</th>
                                            <th>Scale</th>
                                            <th>Scales</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-detail">
                                        <tr>
                                            <td><input type="text" class="form-control" name="detail_size"
                                                    id="detail_size" readonly>
                                            </td>
                                            <td><input type="text" class="form-control" name="detail_qty"
                                                    id="detail_qty" readonly></td>
                                            <td><input type="text" class="form-control" name="detail_scale"
                                                    id="detail_scale"></td>
                                            <td><input type="text" class="form-control" name="detail_scales"
                                                    id="detail_scales"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
{{-- @endforeach --}}

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
            var count = 1;

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

            $('#color_form').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                    url:"{{ route('autocomplete.color_form') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#color_formlist').fadeIn();
                            $('#color_formlist').html(data);
                            } else {
                            $('#color_formlist').fadeOut();
                            $('#color_formlist').empty();
                            $('#color_form').val('');
                            }
                        }
                    });
                }
            });
            // $('#fabric_construct').keyup(function(){
            //     var query = $(this).val();
            //     if(query != ''){
            //         var _token = $('input[name="_token"]').val();
            //         $.ajax({
            //             url:"{{ route('autocomplete.fabricconst') }}",
            //             method:"POST",
            //             data:{query:query, _token:_token},
            //             success:function(data){
            //                 if (data!='') {
            //                     $('#fabric_constructlist').fadeIn();
            //                     $('#fabric_constructlist').html(data);
            //                     } else {
            //                     $('#fabric_constructlist').fadeOut();
            //                     $('#fabric_constructlist').empty();
            //                     $('#id_fabric_construct').val('');
            //                     $('#fabric_construct').val('');
            //                 }
            //             }
            //         });
            //     }
            // });
            // $('#fabric_compost').keyup(function(){
            //     var query = $(this).val();
            //     var fabricconstruct_id = $('input[name="id_fabric_construct"]').val();
            //     if(query != ''){
            //         var _token = $('input[name="_token"]').val();
            //         $.ajax({
            //             url:"{{ route('autocomplete.fabriccomp') }}",
            //             method:"POST",
            //             data:{query:query, fabricconstruct_id:fabricconstruct_id, _token:_token},
            //             success:function(data){
            //                 if (data!='') {
            //                 $('#fabric_compostlist').fadeIn();
            //                 $('#fabric_compostlist').html(data);
            //                 } else {
            //                 $('#fabric_compostlist').fadeOut();
            //                 $('#fabric_compostlist').empty();
            //                 $('#fabric_compost').val('');
            //                 }
            //             }
            //         });
            //     }
            // });
            $('#fabricconst').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.fabricconst') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
            if (data!='') {
            $('#fabricconstlist').fadeIn();
            $('#fabricconstlist').html(data);
            } else {
            $('#fabricconstlist').fadeOut();
            $('#fabricconstlist').empty();
            $('#id_fabricconst').val('');
            $('#fabricconst').val('');
            }
            }
            });
            }
            });
            $('#fabriccomp').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
            var _token = $('input[name="_token"]').val();
            var id_fabricconst = $('#id_fabricconst').val();
            $.ajax({
            url:"{{ route('autocomplete.fabriccomp') }}",
            method:"POST",
            data:{query:query, _token:_token, id_fabricconst:id_fabricconst},
            success:function(data){
            if (data!='') {
            $('#fabriccomplist').fadeIn();
            $('#fabriccomplist').html(data);
            } else {
            $('#fabriccomplist').fadeOut();
            $('#fabriccomplist').empty();
            $('#id_fabriccomp').val('')
            $('#fabriccomp').val('');
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
        function pilihColor_form($ls){
            var ls = $ls;
            var ls = $ls;
            $('#color_form').val($('#col'+ls).text());
            $('#color_formlist').fadeOut();
        }
        // function pilihFabricconstruct($ls){
        //     var ls = $ls;
        //     var ls = $ls;
        //     $('#id_fabric_construct').val($('#id_fabricconst'+ls).text());
        //     $('#fabric_construct').val($('#fabricconst'+ls).text());
        //     $('#fabric_constructlist').fadeOut();
        // }

        // function pilihFabriccompost($ls){
        //     var ls = $ls;
        //     var ls = $ls;
        //     $('#fabric_compost').val($('#fabriccomp'+ls).text());
        //     $('#fabric_compostlist').fadeOut();
        // }
        function pilihFabricconstruct($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabricconst').val($('#id_fabricconst'+ls).text());
        $('#fabricconst').val($('#fabricconst'+ls).text());
        $('#fabricconstlist').fadeOut();
        }
        function pilihFabriccompost($ls){
        var ls = $ls;
        var ls = $ls;
        $('#id_fabriccomp').val($('#id_fabriccomp'+ls).text());
        $('#fabriccomp').val($('#fabriccomp'+ls).text());
        $('#fabriccomplist').fadeOut();
        }

        // function newType(){
        //     console.log("new-type");
        // }

        // function newDetail(){
        //     console.log("new-detail");
        // }

        $(document).on("click", "#click_newtype", function(){
            console.log('aaa');
            var id_wsheet = $(this).data('wsheet');
            $("#id_wsheet").val(id_wsheet);
            // As pointed out in comments,
            // it is unnecessary to have to manually call the modal.
            // $('#addBookDialog').modal('show');
        });

        $(document).on("click", "#click_newdetail", function(){
            console.log('bbb');

            var id_type = $(this).data("detype");
            var size = $(this).data("desize");
            var qty = $(this).data("deqty");

            $("#id_type").val(id_type);
            $("#detail_size").val(size);
            $("#detail_qty").val(qty);
        });
</script>

<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

<script type="text/javascript">
    var count = 1;
    // MCP WORKSHEET
    function ms_addrow(){
        count++;
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
        for (i=1; i<=count; i++){
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

    function calculate_d(){
        var panjang = document.getElementById('panjang_m').value;
        var tole_panjang = document.getElementById('tole_pjg_m').value;
        var lebar = document.getElementById('lebar_m').value;
        var tole_lebar = document.getElementById('tole_lbr_m').value;
        var gramasi = document.getElementById('gramasi').value;
        var skala = document.getElementById('total_skala').value;
        var jml_ampar = document.getElementById('jml_ampar').value;
        var detail_scale = document.getElementById('total_skala').value;

        // Perhitungan Lebar (m) to (inc)
        var lebar_inc = lebar * 39.37;
        document.getElementById('lebar_inc').value = Math.round(lebar_inc * 100)/100;

        //	Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
        var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
        console.log('kons_kgdz = ' + kons_kgdz);
        document.getElementById('kons_kgdz').value = Math.round(kons_kgdz * 100)/100;

        //	Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi)  / 0.914 / Skala x 12
        var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
        console.log('kons_yddz = ' + kons_yddz);
        document.getElementById('kons_yddz').value = Math.round(kons_yddz * 100)/100;

        //	Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12
        var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala * 12;
        console.log('kons_mdz = ' + kons_mdz);
        document.getElementById('kons_mdz').value = Math.round(kons_mdz * 100)/100;

        // isi input scale = total_skala
        document.getElementById('detail_scale').value = detail_scale;

        // isi input scales = scale * jumlah ampar
        var detail_scales = detail_scale * jml_ampar;
        document.getElementById('detail_scales').value = detail_scales;

        // Perhitungan Qty per Yard, Kg dan meter = Jumlah Ampar x Total Skala x Konsumsi / 12
        var qty_yard = jml_ampar * detail_scale * kons_yddz / 12;
        var qty_kg = jml_ampar * detail_scale * kons_kgdz / 12;
        var qty_m = jml_ampar * detail_scale * kons_mdz / 12;

        document.getElementById('qty_yard').value = Math.round(qty_yard * 100)/100;
        document.getElementById('qty_kg').value = Math.round(qty_kg * 100)/100;
        document.getElementById('qty_m').value = Math.round(qty_m * 100)/100;

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
