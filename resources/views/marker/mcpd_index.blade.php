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

    @if (session('alert'))
    <div class="alert alert-success">
        {{ session('alert') }}
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

                <a href="/mcp/print_mcp/{{$mcp->id}}" target="_blank" class="btn btn-info btn-sm">Rekap Konsumsi</a>
                <a href="/mcp/print_rekpiping/{{$mcp->id}}" target="_blank" class="btn btn-info btn-sm">Rekap Piping</a>
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
                                        <a class="dropdown-item" href="/mcp/print_wsm/{{$mcp->id}}/{{$mcpwsm->id}}"
                                            target="_blank">
                                            Print All</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_ws/{{$mcpwsm->id}}/{{$mcp->id}}">Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#form"
                                            data-wsheet="{{$mcpwsm->id}}" id="click_newtype">New
                                            Type</a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_ws/{{$mcpwsm->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan=" 6">
                                {{-- membuat array disini --}}
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

                        <tr style="background-color: #696969; color: #fff">
                            <td></td>
                            <td colspan="7"><b>MARKER & APLIKASI</b></td>
                        </tr>

                        @foreach ($mcp_type as $mcpt)
                        <?php if($mcpt['id_wsheet'] == $mcpwsm['id']) { ?>

                        {{-- MARKER & APPLIKASI--}}
                        <?php if ($mcpt['type'] == 'MARKER' || $mcpt['type'] == 'APLIKASI') { ?>
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
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                                        {{-- <a class="dropdown-item" href="#">Print Rekap Hitung</a> --}}

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpt/{{$mcpt->id}}/{{$mcp->id}}">Edit</a>
                                        <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}"
                                            target="_blank" class="dropdown-item">Print Rekap
                                            Hitung</a>
                                        <a class="dropdown-item click_newdetail" href="#" data-toggle="modal"
                                            data-target="#form-detail" data-mcptid="{{$mcpt->id}}"
                                            data-mcpwsmid="{{$mcpwsm['id']}}" id="click_newdetail">New Detail
                                        </a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpt/{{$mcpt->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @elseif ($mcp->state == "CONFIRMED")
                                        <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}"
                                            target="_blank" class="dropdown-item">Print Rekap
                                            Hitung</a>
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
                            <td><a href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$mcpwsm->id}}"
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
                                        <a class="dropdown-item" href="/mcp/print_detail/{{$mcpd->pdf_marker}}"
                                            target="_blank">Print Detail</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$mcpwsm->id}}">Edit</a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpd/{{$mcpd->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        {{-- <tr> --}}
                        {{-- <td colspan="6"></td> --}}
                        {{-- <td colspan="2" class="text-center">
                                <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}/{{$mcpd->id}}"
                        target="_blank" class="btn btn-primary btn-sm">Print Rekap Hitungg</a>
                        </td> --}}
                        {{-- <td colspan="2" class="text-center"><a
                                    href="{{ route('mcp.print_ws', ['mcp_id' => $mcp->id, '$mcpwsm_id' => $mcpwsm_print, 'mcpt_id' => $mcpt->id, 'mcpd_id' => $mcpd->id]) }}"
                        target="_blank" class="btn btn-primary">Print Document</a></td> --}}
                        {{-- </tr> --}}
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                        {{-- end if type = marker or aplikasi --}}

                        <?php } ?>
                        {{-- end if marker type = marker wsheet main --}}


                        @endforeach
                        {{-- end MARKER & APLIKASI foreach type --}}


                        <tr style="background-color: #696969; color: #fff">
                            <td></td>
                            <td colspan="7"><b>KAIN KERAS</b></td>
                        </tr>

                        @foreach ($mcp_type as $mcpt)
                        <?php if($mcpt['id_wsheet'] == $mcpwsm['id']) { ?>

                        {{-- KAIN KERAS --}}
                        <?php if ($mcpt['type'] == 'KAIN KERAS') { ?>
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

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpt/{{$mcpt->id}}/{{$mcp->id}}">Edit</a>
                                        <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}"
                                            target="_blank" class="dropdown-item">Print Rekap
                                            Hitung</a>
                                        <a class="dropdown-item click_newdetail" href="#" data-toggle="modal"
                                            data-target="#form-detail" data-mcptid="{{$mcpt->id}}"
                                            data-mcpwsmid="{{$mcpwsm['id']}}" id="click_newdetail">New Detail
                                        </a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpt/{{$mcpt->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
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
                            <td><a href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$mcpwsm->id}}"
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
                                        <a class="dropdown-item" href="/mcp/print_detail/{{$mcpd->pdf_marker}}">Print
                                            Detail</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$mcpwsm->id}}">Edit</a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpd/{{$mcpd->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>

                        <?php } ?>
                        {{-- end if marker type = marker wsheet main --}}
                        @endforeach
                        {{-- end KAIN KERAS foreach type  --}}

                        {{-- PIPING --}}
                        <tr style="background-color: #696969; color: #fff">
                            <td></td>
                            <td colspan="7"><b>PIPING</b></td>
                        </tr>

                        @foreach ($mcp_type as $mcpt)
                        <?php if($mcpt['id_wsheet'] == $mcpwsm['id']) { ?>

                        <?php if ($mcpt['type'] == 'PIPING') { ?>
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
                                        {{-- <a class="dropdown-item" href="#">Print Rekap Hitung</a> --}}

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpt/{{$mcpt->id}}/{{$mcp->id}}">Edit</a>
                                        <a class="dropdown-item pi_click_newdetail" href="#" data-toggle="modal"
                                            data-target="#form-piping" data-mcptid="{{$mcpt->id}}"
                                            data-mcpwsmid="{{$mcpwsm['id']}}" id="pi_click_newdetail">New Detail
                                        </a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpt/{{$mcpt->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php foreach ($mcp_detail_pi as $mcpi) { ?>
                        <?php if($mcpi['id_type'] == $mcpt['id']) { ?>
                        <tr>
                            <td colspan="2"></td>
                            <td><b>Marker ke</b></td>
                            <td><b>Code</b></td>
                            <td><b>Efisiensi (%)</b></td>
                            <td><b>Perimeter</b></td>
                            <td><b>Tolerance</b></td>
                            <td><b>Action</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td><a href="/mcp/edit_mcpi/{{$mcpi->id}}/{{$mcp->id}}/{{$mcpwsm->id}}"
                                    id="click_showdetail">M
                                    {{$mcpi->urutan}}</a>
                            </td>
                            <td>{{$mcpi->kode_marker}}</td>
                            <td>{{$mcpi->efisiensi}}</td>
                            <td>{{$mcpi->perimeter}}(m)</td>
                            <td>{{$mcpi->tolerance}}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="/mcp/print_detail/{{$mcpi->pdf_marker}}"
                                            target="_blank">
                                            Print Detail</a>

                                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                                        <a class="dropdown-item"
                                            href="/mcp/edit_mcpi/{{$mcpi->id}}/{{$mcp->id}}/{{$mcpwsm->id}}">Edit</a>
                                        <hr>
                                        <a class="dropdown-item" href="/mcp/delete_mcpi/{{$mcpi->id}}"
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>

                        <?php } ?>
                        {{-- end if marker type = marker wsheet main --}}
                        @endforeach
                        {{-- end PIPING foreach type  --}}


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
                                    <input type="hidden" id="ws_count" name="ws_count" value=1>
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

            <form action="{{route('mcp.createdetail_ma')}}" method="POST" enctype="multipart/form-data" id="ma_form">
                {{ csrf_field() }}
                <div class="modal-content" id="modal-content" style="width: 120%;">
                    <div class="modal-header">
                        <h3>New Detail</h3>
                        <span class="mr-0">
                            <a data-dismiss="modal" onclick="batalDetail('#detail-ass-tbody')"
                                class="btn btn-danger text-white">X</a>
                        </span>
                    </div>

                    {{-- ------------------------------------------------------------- --}}
                    <input type="hidden" name="ma_mcp" id="ma_mcp" value="{{$mcp->number}}">
                    <input type="hidden" name="ma_id_mcpwsm" id="ma_id_mcpwsm" value="">
                    <input type="hidden" name="ma_id_type" id="ma_id_type" value="">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Marker ke</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" id="ma_urutan"
                                    name="ma_urutan" required></div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_panjang_m" id="ma_panjang_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Total Skala</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_total_skala" id="ma_total_skala" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Code</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="ma_code" id="ma_code"
                                    required>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                            <div class="col-sm-4"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_lebar_m" id="ma_lebar_m">
                            </div>
                            <div class="col-sm-4"><input class="form-control" type="number" step="0.01"
                                    name="ma_lebar_inc" id="ma_lebar_inc" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain Yd/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_kons_yddz" id="ma_kons_yddz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Marker Date</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="ma_marker_date"
                                    id="ma_marker_date" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_tole_pjg_m" id="ma_tole_pjg_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain Kg/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_kons_kgdz" d id="ma_kons_kgdz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_efisiensi" id="ma_efisiensi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_tole_lbr_m" id="ma_tole_lbr_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Kain m/Dz</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_kons_mdz" id="ma_kons_mdz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Perimeter</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_perimeter" id="ma_perimeter">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_gramasi" id="ma_gramasi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (yard)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="ma_qty_yard"
                                    id="ma_qty_yard" readonly style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>*Kons Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_kons_sz_tgh" id="ma_kons_sz_tgh" required>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                                    name="ma_jml_ampar" id="ma_jml_ampar">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (kg)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="ma_qty_kg"
                                    id="ma_qty_kg" readonly style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tgl Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="ma_tgl_sz_tgh"
                                    id="ma_tgl_sz_tgh" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Jumlah Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="ma_jml_marker" id="ma_jml_marker">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" step="0.01" name="ma_qty_m"
                                    id="ma_qty_m" readonly style="background-color: #FFB09F !important;">
                            </div>
                        </div>

                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Komponen / Pcs</b></small></div>
                            <div class="col-sm-8"><textarea class="form-control" type="text" name="ma_komponen"
                                    id="ma_komponen"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="file" name="ma_pdf_marker"
                                    id="ma_pdf_marker">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revisi</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" name="ma_revisi"
                                    id="ma_revisi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revisi Remark</b></small></div>
                            <div class="col-sm-8"><textarea class="form-control" type="text" name="ma_revisi_remark"
                                    id="ma_revisi_remark"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Qty Ws</th>
                                            <th>Scale</th>
                                            <th>Scales</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail-ass-tbody">
                                        {{-- --------------------------isi assortment-------------------------- --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-lg-1 mb-10">
                            <div class="row justify-content-end">
                                <div class="col-sm-4">
                                    <a href="#" class="btn btn-sm btn-warning mx-5" onclick="assort_cal()">Calculate</a>
                                    <a type="button" id="batal_newdetail" data-dismiss="modal" class="mr-15"
                                        onclick="batalDetail('#detail-ass-tbody')"><u>Batal</u></a>
                                    <input type="submit" id="ma_submit_detail" name="ma_submit_detail"
                                        class="btn btn-primary ml-10">
                                    <div class="col-sm-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- modal piping --}}
    <div class="modal fade" id="form-piping" role="dialog">
        <div class="modal-dialog modal-lg">

            <form action="{{route('mcp.createdetail_pi')}}" method="POST" enctype="multipart/form-data" id="pi_form">
                {{ csrf_field() }}
                <div class="modal-content" id="modal-content" style="width: 120%;">
                    <div class="modal-header">
                        <h3>New Detail Piping</h3>
                        <span class="mr-0">
                            <a data-dismiss="modal" class="btn btn-danger text-white"
                                onclick="batalDetail('#detail-ass-tbody')">X</a>
                        </span>
                    </div>

                    <input type="hidden" name="pi_mcp" id="pi_mcp" value="{{$mcp->number}}">
                    <input type="hidden" name="pi_id_mcpwsm" id="pi_id_mcpwsm" value="">
                    <input type="hidden" name="pi_id_type" id="pi_id_type" value="">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Piping Untuk</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" id="pi_untuk" name="pi_untuk">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Panjang (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_panjang_m" id="pi_panjang_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Total WS Quantity</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_tot_ws_qty" id="pi_tot_ws_qty" value="{{$qty_for_detail}}"
                                    style="background-color: #FFB09F !important;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Ukuran (Cm)</b></small></div>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" step="0.01" id="pi_ukuran" name="pi_ukuran">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Lebar (m)</b></small></div>
                            <div class="col-sm-4"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_lebar_m" id="pi_lebar_m">
                            </div>
                            <div class="col-sm-4"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_lebar_inc" id="pi_lebar_inc" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Kg)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_be_kg" id="pi_qty_be_kg" style="background-color: #FFB09F !important;"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Arah</b></small></div>
                            <div class="col-sm-8">
                                <select class="form-control" name="pi_arah" id="pi_arah">
                                    <option value="" selected disabled>Select</option>
                                    <option value="diagonal">Diagonal</option>
                                    <option value="horizontal">Horizontal</option>
                                    <option value="vertikal">Vertikal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Meter per Pcs</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01" name="pi_mp_pcs"
                                    id="pi_mp_pcs">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Yd)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_be_yd" id="pi_qty_be_yd" style="background-color: #FFB09F !important;"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Marker ke</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" id="pi_urutan"
                                    name="pi_urutan" required></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>Pola Asli</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="pi_pola_asli"
                                    id="pi_pola_asli">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty Before Tole (Mtr)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_be_mtr" id="pi_qty_be_mtr"
                                    style="background-color: #FFB09F !important;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Kode Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="text" name="pi_kode_marker"
                                    id="pi_kode_marker" required>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Gramasi</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_gramasi" id="pi_gramasi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tolerance (%)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_tolerance" id="pi_tolerance">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-4 text-right"><small><b>*Marker Date</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="pi_marker_date"
                                    id="pi_marker_date" value="{{date('Y-m-d')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Skala</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_skala" id="pi_skala">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty After Tole (Kg)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_af_kg" id="pi_qty_af_kg" style="background-color: #FFB09F !important;"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Efisiensi (%)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_efisiensi" id="pi_efisiensi">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Jumlah Ampar</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_jml_ampar" id="pi_jml_ampar">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty After Tole (Yd)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_af_yd" id="pi_qty_af_yd" style="background-color: #FFB09F !important;"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Perimeter (Cm)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_perimeter" id="pi_perimeter">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_kons_sz_tgh" id="pi_kons_sz_tgh">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Qty After Tole (Mtr)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_qty_af_mtr" id="pi_qty_af_mtr"
                                    style="background-color: #FFB09F !important;" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Pjg (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_tole_pjg_m" id="pi_tole_pjg_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>*Tgl Sz Tgh</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="date" name="pi_tgl_sz_tgh"
                                    id="pi_tgl_sz_tgh" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revision</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" name="pi_revision"
                                    id="pi_revision">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Tole Lbr (m)</b></small></div>
                            <div class="col-sm-8"><input class="form-control form-detail-pi" type="number" step="0.01"
                                    name="pi_tole_lbr_m" id="pi_tole_lbr_m">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons (Kg/Dz)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_kons_kgdz" id="pi_kons_kgdz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Revision Remark</b></small></div>
                            <div class="col-sm-8"><textarea class="form-control" type="text" name="pi_revision_remark"
                                    id="pi_revision_remark"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>PDF Marker</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="file" name="pi_pdf_marker"
                                    id="pi_pdf_marker">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons (Yd/Dz)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_kons_yddz" d id="pi_kons_yddz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-lg-1"></div>
                        <div class="col-sm-4 mt-lg-1"></div>
                        <div class="col-sm-4 mt-lg-1">
                            <div class="col-sm-4 text-right"><small><b>Kons (M/Dz)</b></small></div>
                            <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                                    name="pi_kons_mdz" id="pi_kons_mdz" readonly
                                    style="background-color: #FFB09F !important;">
                            </div>
                        </div>
                        <div class="col-sm-12 mt-lg-1 mb-10">
                            <div class="row justify-content-end">
                                <div class="col-sm-4">
                                    <a type="button" id="pi_batal_newdetail" data-dismiss="modal" class="mr-15"
                                        onclick="batalDetail('#detail-ass-tbody')"><u>Batal</u></a>
                                    <input type="submit" id="pi_submit_detail" name="pi_submit_detail"
                                        class="btn btn-primary ml-10">
                                    <div class="col-sm-4">
                                    </div>
                                </div>
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

            $('#fabricconst').keyup(function(){
                var query = $(this).val();
                if(query != '') {
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
                if(query != ''){
                    var id_fabricconst = $('#id_fabricconst').val();
                    var _token = $('input[name="_token"]').val();
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

        function batalDetail(id) {
            const parent = document.querySelector(id);

            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }

            $('#ma_form').find(':input').each(function() {
                switch (this.type) {
                case 'text':
                case 'number':
                case 'file':
                case 'textarea':
                $(this).val('');
                break;
                }
            });

            $('#pi_form').find(':input').each(function() {
                switch (this.type) {
                case 'text':
                case 'number':
                case 'file':
                case 'textarea':
                $(this).val('');
                break;
                }
            });
        }

        $(document).on("click", "#click_newtype", function(){
            var id_wsheet = $(this).data('wsheet');
            $("#id_wsheet").val(id_wsheet);
        });

            $(document).ready(function(){
                $('.click_newdetail').click(function(){
                    var mcpwsmid = $(this).data("mcpwsmid");
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"/mcp/getsize",
                        method:"POST",
                        data:{mcpwsmid:mcpwsmid, _token:_token},
                        success:function(data){
                            console.log(data);

                            var i;
                            for(i=0; i<data.length; i++){
                                baris = '<tr>'+
                                    '<td>'+'<input class="form-control form-detail" type="text" name="input_det_size[]" id="input_det_size_'+i+'" value="'+data[i].size+'" readonly>'+'</td>'+
                                    '<td>'+'<input class="form-control form-detail" type="number" name="input_det_qty[]" id="input_det_qty_'+i+'" value="'+data[i].qty_tot+'" readonly>'+'</td>'+
                                    '<td>'+'<input class="form-control form-detail" type="number" name="input_det_scale[]" id="input_det_scale_'+i+'">'+'</td>'+
                                    '<td>'+'<input class="form-control form-detail" type="number" name="input_det_scales[]" id="input_det_scales_'+i+'"'+'style="background-color: #FFB09F !important;"'+'readonly>'+'</td>'+
                                '</tr>'
                                $('#detail-ass-tbody').append(baris);
                            }
                            baris2 = '<input type="hidden" name="index_assort" id="index_assort" value="'+i+'">'
                            $('#detail-ass-tbody').append(baris2);
                        }
                    });

                    var id_mcpwsm = $(this).data("mcpwsmid");
                    var id_mcpt = $(this).data("mcptid");

                    $("#ma_id_type").val(id_mcpt);
                    $("#ma_id_mcpwsm").val(id_mcpwsm);
                    document.getElementById("ma_submit_detail").disabled = true;
                });

                $('.pi_click_newdetail').click(function(){
                    var id_mcpwsm = $(this).data("mcpwsmid");
                    var id_mcpt = $(this).data("mcptid");
                    $("#pi_id_mcpwsm").val(id_mcpwsm);
                    $("#pi_id_type").val(id_mcpt);
                });
            });
</script>

<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

<script type="text/javascript">
    var count = 1;
    // MCP WORKSHEET
    function ms_addrow(){
        count = document.getElementById("ws_count").value;
        count++;

        baris = '<tr>'+
        '<td>'+'<input class="form-control" type="text" name="input_size[]" id="input_size_'+count+'">'+'</td>'+
            '<td>'+'<input class="form-control" type="number" name="input_ws_qty[]" id="input_ws_qty_'+count+'">'+'</td>'+
            '<td>'+'<input class="form-control" type="number" name="input_tolerance[]" id="input_tolerance_'+count+'">'+'</td>'+
            '<td>'+'<input class="form-control" type="number" name="input_qty_tot[]" id="input_qty_tot_'+count+'" readonly>'+'</td>'+
            '<td>'+'<button class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove(); minCount();">X</button>'+'</td>' +
        '</tr>'
        $('#ws_tbody').append(baris);

        document.getElementById("ws_count").value = count;
    }

    function minCount() {
        var count = document.getElementById("ws_count").value;
        count--;
        document.getElementById("ws_count").value=count;
    }

    $('#click_create').click(function(){
        $('#submit').prop('disabled',true);
    });

    function assort_cal(){
        // mendapatkan total skala secara otomatis
        var index_assort = document.getElementById('index_assort').value;
        var jml_ampar = document.getElementById('ma_jml_ampar').value;
        var jml_marker = document.getElementById('ma_jml_marker').value;
        var tot_ass_scale = 0;
        var tot_ass_scales = 0;

        for(i = 0; i < index_assort; i++){
            // var ass_qtyws = document.getElementById("input_det_qty_"+i).value;
            var ass_scale = document.getElementById("input_det_scale_"+i).value;
            var ass_scales = jml_ampar * jml_marker * ass_scale;
            document.getElementById("input_det_scales_"+i).value = ass_scales;
            tot_ass_scale += parseInt(ass_scale);
            tot_ass_scales = tot_ass_scales + ass_scales;
        }
        document.getElementById("ma_total_skala").value = tot_ass_scale;
        document.getElementById("ma_submit_detail").disabled = false;

        var panjang = document.getElementById('ma_panjang_m').value;
            var tole_panjang = document.getElementById('ma_tole_pjg_m').value;
            var lebar = document.getElementById('ma_lebar_m').value;
            var tole_lebar = document.getElementById('ma_tole_lbr_m').value;
            var gramasi = document.getElementById('ma_gramasi').value;
            var skala = document.getElementById('ma_total_skala').value;
            var jml_ampar = document.getElementById('ma_jml_ampar').value;
            // var detail_scale = document.getElementById('total_skala').value;

            // Perhitungan Lebar (m) to (inc)
            var lebar_inc = lebar * 39.37;
            $("#ma_lebar_inc").val(lebar_inc.toFixed(2));

            //	Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
            var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
            $("#ma_kons_kgdz").val(kons_kgdz.toFixed(2));

            //	Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi)  / 0.914 / Skala x 12
            var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
            $("#ma_kons_yddz").val(kons_yddz.toFixed(2));

            //	Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12
            var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala * 12;
            $("#ma_kons_mdz").val(kons_mdz.toFixed(2));

            // Perhitungan Qty per Yard, Kg dan meter = Jumlah Ampar x Total Skala x Konsumsi / 12
            var qty_yard = jml_ampar * skala * kons_yddz / 12;
            var qty_kg = jml_ampar * skala * kons_kgdz / 12;
            var qty_m = jml_ampar * skala * kons_mdz / 12;

            $("#ma_qty_yard").val(qty_yard.toFixed(2));
            $("#ma_qty_kg").val(qty_kg.toFixed(2));
            $("#ma_qty_m").val(qty_m.toFixed(2));
    }

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


    $(document).ready(function(){
        $(".form-detail-ma").keyup(function(){

            var panjang = document.getElementById('ma_panjang_m').value;
            var tole_panjang = document.getElementById('ma_tole_pjg_m').value;
            var lebar = document.getElementById('ma_lebar_m').value;
            var tole_lebar = document.getElementById('ma_tole_lbr_m').value;
            var gramasi = document.getElementById('ma_gramasi').value;
            var skala = document.getElementById('ma_total_skala').value;
            var jml_ampar = document.getElementById('ma_jml_ampar').value;
            // var detail_scale = document.getElementById('total_skala').value;

            // Perhitungan Lebar (m) to (inc)
            var lebar_inc = lebar * 39.37;
            $("#ma_lebar_inc").val(lebar_inc.toFixed(2));

            //	Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
            var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
            $("#ma_kons_kgdz").val(kons_kgdz.toFixed(2));

            //	Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi)  / 0.914 / Skala x 12
            var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
            $("#ma_kons_yddz").val(kons_yddz.toFixed(2));

            //	Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12
            var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala * 12;
            $("#ma_kons_mdz").val(kons_mdz.toFixed(2));

            // Perhitungan Qty per Yard, Kg dan meter = Jumlah Ampar x Total Skala x Konsumsi / 12
            var qty_yard = jml_ampar * skala * kons_yddz / 12;
            var qty_kg = jml_ampar * skala * kons_kgdz / 12;
            var qty_m = jml_ampar * skala * kons_mdz / 12;

            $("#ma_qty_yard").val(qty_yard.toFixed(2));
            $("#ma_qty_kg").val(qty_kg.toFixed(2));
            $("#ma_qty_m").val(qty_m.toFixed(2));
        });

        $(".form-detail-pi").keyup(function(){
            // Perhitungan Lebar (m) to (inc)
            var lebar = document.getElementById('pi_lebar_m').value;
            var lebar_inc = lebar * 39.37;
            document.getElementById('pi_lebar_inc').value = Math.round(lebar_inc * 100)/100;

            // Perhitungan Quantity
            val_fabric_yard = 0;
            val_fabric_kg = 0;
            val_fabric_meter = 0;
            val_before_tolerance_kg = 0;
            val_before_tolerance_yard = 0;
            val_before_tolerance_meter = 0;

            val_length = parseFloat($("#pi_panjang_m").val());
            val_width = parseFloat($("#pi_lebar_m").val());
            val_length_tole = parseFloat($("#pi_tole_pjg_m").val());
            val_width_tole = parseFloat($("#pi_tole_lbr_m").val());
            val_gramasi = parseFloat($("#pi_gramasi").val());
            val_scale = parseFloat($("#pi_skala").val());
            val_ws_quantity = parseFloat($("#pi_tot_ws_qty").val());
            val_tolerance = parseFloat($("#pi_tolerance").val());

            // Consumption before tolerance
            val_fabric_kg = ((((val_length + val_length_tole) * (val_width + val_width_tole) * val_gramasi) / val_scale) * 12) /1000;
            val_fabric_yard = (((val_length + val_length_tole) / val_scale ) / 0.914) * 12;
            val_fabric_meter = ((val_length + val_length_tole) / val_scale) * 12

            if (isNaN(val_fabric_kg) == true || val_scale == 0)
            val_fabric_kg = 0;

            if (isNaN(val_fabric_yard) == true || val_scale == 0)
            val_fabric_yard = 0;

            if (isNaN(val_fabric_meter) == true || val_scale == 0)
            val_fabric_meter = 0;

            $("#pi_kons_kgdz").val(val_fabric_kg.toFixed(2));
            $("#pi_kons_yddz").val(val_fabric_yard.toFixed(2));
            $("#pi_kons_mdz").val(val_fabric_meter.toFixed(2));

            // Quantity before Tolerance
            val_before_tolerance_kg = (val_fabric_kg.toFixed(2) * val_ws_quantity) / 12;
            val_before_tolerance_yard = (val_fabric_yard.toFixed(2) * val_ws_quantity) / 12;
            val_before_tolerance_meter = (val_fabric_meter.toFixed(2) * val_ws_quantity) / 12;

            $("#pi_qty_be_kg").val(val_before_tolerance_kg.toFixed(2));
            $("#pi_qty_be_yd").val(val_before_tolerance_yard.toFixed(2));
            $("#pi_qty_be_mtr").val(val_before_tolerance_meter.toFixed(2));

            // Quantity after Tolerance
            val_after_tolerance_kg = val_before_tolerance_kg + (val_before_tolerance_kg * val_tolerance / 100);
            val_after_tolerance_yard = val_before_tolerance_yard + (val_before_tolerance_yard * val_tolerance / 100);
            val_after_tolerance_meter = val_before_tolerance_meter + (val_before_tolerance_meter * val_tolerance / 100);

            $("#pi_qty_af_kg").val(val_after_tolerance_kg.toFixed(2));
            $("#pi_qty_af_yd").val(val_after_tolerance_yard.toFixed(2));
            $("#pi_qty_af_mtr").val(val_after_tolerance_meter.toFixed(2));
        });
    });

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
