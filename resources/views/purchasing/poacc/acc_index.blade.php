@extends('layouts.app')

@section('content')

<?php
function rupiah($angka){

	$hasil_rupiah = number_format($angka,2,',','.');
	return $hasil_rupiah;

}
?>

<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/purchasing/acc_orders')}}">PO Aksesoris</a></li>
        <li class="breadcrumb-item active">Show</li>
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
        <div class="card-body">
            <div class="row text-size-small">
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">Number</div>
                    <div class="col-sm-7">: {{$acc->number}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Supplier</div>
                    <div class="col-sm-7">: {{$acc->supplier}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Currency</div>
                    <div class="col-sm-7">: {{$acc->currency}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Order Date</div>
                    <div class="col-sm-7">: {{$acc->order_date}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Allowance Overshipment</div>
                    <div class="col-sm-7">: {{$acc->allowance_qty}}</div>
                    <br>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">Start Date</div>
                    <div class="col-sm-7">: {{$acc->start_date}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">End Date</div>
                    <div class="col-sm-7">: {{$acc->end_date}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Exchange Rate</div>
                    <div class="col-sm-7">: {{rupiah($acc->exchange_rate)}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Price Term</div>
                    <div class="col-sm-7">: {{$acc->price_term}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Payment Term</div>
                    <div class="col-sm-7">: {{$acc->payment_term}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Bank Charges</div>
                    <div class="col-sm-7">: {{$acc->bank_charges}}</div>
                    <br>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-5 font-weight-bold">Note</div>
                    <div class="col-sm-7">: {{$acc->note}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">State</div>
                    <div class="col-sm-7">: {{$acc->state}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Created By</div>
                    <div class="col-sm-7">: {{$acc->created_by}}</div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Updated By</div>
                    <div class="col-sm-7">: </div>
                    <br>
                    @if ($acc->state == 'UNCONFIRMED')
                    <div class="col-sm-5 font-weight-bold">Unconfirmed By</div>
                    <div class="col-sm-7">: </div>
                    <br>
                    @endif
                    <div class="col-sm-5 font-weight-bold">SPM</div>
                    <div class="col-sm-7">: </div>
                    <br>
                    <div class="col-sm-5 font-weight-bold">Printed Count</div>
                    <div class="col-sm-7">: {{$acc->printed_count}}</div>
                    <br>
                </div>

            </div>
            <div class="row mt-20">
                <div class="col-sm-12">
                    <a id="btn_edit_acc" class="btn btn-primary btn-sm" href="#modal_index_edit" data-toggle="modal"
                        role="button" onclick="getDetail({{$acc->id}})">Edit</a>
                    <a class="btn btn-default btn-sm" href="{{url('/purchasing/acc_orders')}}" role="button">Back</a>
                    <a id="btn_review_acc" onclick="" class="btn btn-danger btn-sm" href="#" role="button">Review</a>
                    <a id="btn_confirm_acc" onclick="" class="btn btn-success btn-sm" href="#" role="button">Confirm</a>
                    <a id="btn_unconfirm_acc" onclick="" class="btn btn-warning btn-sm" href="#"
                        role="button">Unconfirm</a>
                    <a id="btn_preview_acc" onclick="" class="btn btn-danger btn-sm" href="#" role="button">Preview</a>
                    <a id="btn_print_acc" onclick="" class="btn btn-info btn-sm" href="#" role="button">Print</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-20">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <a id="btn_new_material" class="btn btn-default btn-sm" href="#modal_material_new" onclick="submit_material('create')"
                        data-toggle="modal" role="button"><small>New Material</small></a>
                    <a href="#modal_import_material" data-toggle="modal" class="btn btn-default btn-sm"
                        id="btn_import_material"><small>Import
                            Material</small></a>
                    <a href="#" class="btn btn-default btn-sm"><small>Sample Import Material</small></a>
                    <a href="#modal_convert_unit" data-toggle="modal" class="btn btn-default btn-sm"><small>Convert Unit</small></a>
                    <a href="#" class="btn btn-default btn-sm"><small>Edit All Requirements</small></a>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-sm-12">
                    <a href="#" class="btn btn-success btn-sm"><small>Select All</small></a>
                    <a href="#" class="btn btn-warning btn-sm"><small>Unselect All</small></a>
                    <a href="#modal_material_new" onclick="submit_material('update')" data-toggle="modal" class="btn btn-primary btn-sm"><small>Edit Material</small></a>
                    <a href="#" onclick="materialDelete()" class="btn btn-danger btn-sm"><small>Delete Material</small></a>
                </div>
            </div>
            <div class="row">
                <input type="hidden" name="selected_id_poacc_material" id="selected_id_poacc_material">
                <table class="table table-bordered table-hover" id="table_material">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis</th>
                        <th>Material</th>
                        <th>Keterangan</th>
                        <th>No Order</th>
                        <th>Budget Q</th>
                        <th>Budget PO</th>
                        <th>Style</th>
                        <th>Shipping Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($acc_material as $acc_m)
                        <tr onclick="selectMaterial({{$acc_m->id}})">
                            <td><input type="checkbox" name="check_material"></td>
                            <td>{{$acc_m->fabricconst->name}}</td>
                            <td>{{$acc_m->fabriccomp->name}}</td>
                            <td>{{$acc_m->fabric_desc}}</td>
                            <td>{{$acc_m->salesorder->number}}</td>
                            <td>{{rupiah($acc_m->budget)}}</td>
                            <td>budget_po</td>
                            <td>{{$acc_m->style->name}}</td>
                            <td>{{$acc_m->shipping_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-20">
        <div class="card-body">
            <div class="row">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Color</th>
                        <th>Supplier Color</th>
                        <th>Size</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Total Requirement</th>
                        <th>Round</th>
                    </tr>
                    <tbody id="table_material_br">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card mt-20">
            <div class="card-body">
                <a href="#modal_convert_unit" data-toggle="modal" class="btn btn-default btn-sm"><small>Convert Unit</small></a>
                <div class="row mt-2">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Source</th>
                            <th>Target</th>
                            <th>Factor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="table_convert_unit">
                            @foreach ($convert_unit as $cu)
                            <tr>
                                <td>{{$cu->source->name}}</td>
                                <td>{{$cu->target->name}}</td>
                                <td>{{$cu->faktor}}</td>
                                <td align="center"><a href="/purchasing/acc_orders/delete_convert_limit/{{$cu->id}}">(X)</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal edit index --}}
    <div class="row">
        <div id="modal_index_edit" class="modal fade">
            <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
                <div class="modal-content" id="background-body2" style="width: 150% !important;">
                    <form action="/purcashing/acc_orders/update" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Edit PO Accessories</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="hidden" name="edit_id" id="edit_id">
                                        <label for="edit_number">*Number</label>
                                        <input type="text" name="edit_number" id="edit_number"
                                            class="form-control bg-warning" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="edit_order_date">*Order Date</label>
                                        <input type="date" name="edit_order_date" id="edit_order_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="edit_note">Note</label>
                                        <textarea type="text" name="edit_note" id="edit_note" class="form-control"
                                            cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    {{-- <div class="form-group">
                                            <label for="edit_numbering">Numbering</label>
                                            <?php $yearnow = date('Y'); ?>
                                            <input type="text" name="edit_numbering" id="edit_numbering"
                                                class="form-control bg-warning" value="{{'PO ACCS-' . $yearnow}}"
                                    readonly>
                                </div> --}}
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_start_date">*Start Date</label>
                                    <input type="date" name="edit_start_date" id="edit_start_date" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_rounding_value">Rounding Value</label>
                                    <input type="number" name="edit_rounding_value" id="edit_rounding_value"
                                        class="form-control" value="0.00" step="0.01">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_supplier">Supplier</label>
                                    <input type="text" name="edit_supplier" id="edit_supplier" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_end_date">*End Date</label>
                                    <input type="date" name="edit_end_date" id="edit_end_date" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_allowance_qty">Allowance Overshipment Quantity</label>
                                    <input type="number" name="edit_allowance_qty" id="edit_allowance_qty"
                                        class="form-control" value="0.00" step="0.01">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_currency">Currency</label>
                                    <select type="text" name="edit_currency" id="edit_currency" class="form-control">
                                        <option value="rupiah">Rupiah</option>
                                        <option value="us dollar">US Dollar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_price_term">*Price term</label>
                                    <input type="text" name="edit_price_term" id="edit_price_term" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_exchange_rate">*Exchange Rate</label>
                                    <input type="number" name="edit_exchange_rate" id="edit_exchange_rate"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_payment_term">*Payment Term</label>
                                    <input type="text" name="edit_payment_term" id="edit_payment_term"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="edit_bank_charges">Bank Charges</label>
                                    <select type="text" name="edit_bank_charges" id="edit_bank_charges"
                                        class="form-control">
                                        <option value=""> </option>
                                        <option value="full amount">FULL AMOUNT</option>
                                        <option value="shared">SHARED</option>
                                        <option value="supplier">SUPPLIER</option>
                                    </select>
                                </div>
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

    {{-- modal new material --}}
    <div class="row">
        <div id="modal_material_new" class="modal fade">
            <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
                <div class="modal-content" id="background-body2" style="width: 150% !important;">
                    <form name="form_material_new" id="form_material_new" action="/purchasing/acc_orders/create_material" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>New Material</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id_poacc" id="id_poacc" value="{{$acc->id}}">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabricconst">Fabric Construct</label>
                                            <input type="hidden" id="id_fabricconst" type="text"
                                                class="form-control @error('id_fabricconst') is-invalid @enderror"
                                                name="id_fabricconst" value="{{ old('id_fabricconst',0) }}"
                                                autocomplete="off">
                                            <input id="fabricconst" type="text"
                                                class="form-control @error('fabricconst') is-invalid @enderror"
                                                name="fabricconst" value="{{ old('fabricconst') }}" autocomplete="off">
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
                                    <div class="form-group">
                                        {{-- <label for="new_ma_number">Order Number</label> --}}
                                        {{-- <input type="text" name="new_ma_number" id="new_ma_number" class="form-control"> --}}
                                         <div class="input-group">
                                            <label for="new_ma_number">Order Number</label>
                                            <input type="hidden" id="id_new_ma_number" type="text"
                                                class="form-control @error('id_new_ma_number') is-invalid @enderror"
                                                name="id_new_ma_number" value="{{ old('id_new_ma_number',0) }}"
                                                autocomplete="off">
                                            <input id="new_ma_number" type="text"
                                                class="form-control @error('new_ma_number') is-invalid @enderror"
                                                name="new_ma_number" value="{{ old('new_ma_number') }}" autocomplete="off">
                                            <span>
                                                <div id="new_ma_numberlist"></div>
                                            </span>

                                            @error('new_ma_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_ma_budget">Budget</label>
                                        <input type="number" name="new_ma_budget" id="new_ma_budget"
                                            class="form-control" value="0" min="0">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabriccomp">Fabric Compost</label>
                                            <input type="hidden" id="id_fabriccomp" type="text"
                                                class="form-control @error('id_fabriccomp') is-invalid @enderror"
                                                name="id_fabriccomp" value="{{ old('id_fabriccomp',0) }}"
                                                autocomplete="off">
                                            <input id="fabriccomp" type="text"
                                                class="form-control @error('fabriccomp') is-invalid @enderror"
                                                name="fabriccomp" value="{{ old('fabriccomp') }}" autocomplete="off">
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="style">Style Name</label>
                                             <input type="hidden" id="id_new_ma_style"
                                                class="form-control @error('id_new_ma_style') is-invalid @enderror"
                                                name="id_new_ma_style" value="{{ old('id_new_ma_style',0) }}"
                                                autocomplete="off">
                                            <input id="new_ma_style" type="text"
                                                class="form-control @error('style') is-invalid @enderror" name="new_ma_style" value="{{ old('style') }}" autocomplete="off">
                                            <span>
                                                <div id="new_ma_stylelist"></div>
                                            </span>

                                            @error('style')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_ma_material_type">*Material Type</label>
                                        <select type="text" name="new_ma_material_type" id="new_ma_material_type"
                                            class="form-control" required>
                                            <option value="FABRIC">FABRIC</option>
                                            <option value="COLLAR">COLLAR</option>
                                            <option value="CUFF">CUFF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_ma_fabdesc">Fabric Description</label>
                                        <input type="text" name="new_ma_fabdesc" id="new_ma_fabdesc"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_ma_shipping_date">*Shipping Date</label>
                                        <input type="date" name="new_ma_shipping_date" id="new_ma_shipping_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" id="new_ma_add_item" class="btn btn-sm btn-success"
                                        onclick="ma_add_row()"><small>add item</small></button>
                                    <input type="hidden" id="ma_count" name="ma_count" value=0>
                                    <table class="table table-bordered table-condensed mt-2">
                                        <thead>
                                            <tr>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="new_ma_tbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="create_new_material">Create</button>
                            <a href="#" class="btn btn-primary" id="update_new_material" onclick="materialUpdate()">Update</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- modal import material --}}
    <div class="row">
        <div id="modal_import_material" class="modal fade">
            <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
                <div class="modal-content" id="background-body2" style="width: 150% !important;">
                    <form action="#" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Import Material</strong></h6>
                        </div>
                        <div class="modal-body" id="import_material_body">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal convert unit --}}
    <div class="row">
        <div id="modal_convert_unit" class="modal fade">
            <div class="modal-dialog modal-md">
                <div class="modal-content" id="background-body2">
                    <div class="p-10">
                    <form action="/purchasing/acc_orders/convert_unit" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class="modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>Convert Unit</strong></h6>
                        </div>
                        <div class="alert alert-info">
                            <p>Factor (tidak boleh nol)</p>
                            <p>Rumus Konversi: Qty / Faktor</p>
                        </div>
                        <input type="hidden" name="convert_unit_id_poacc" value="{{$acc->id}}">
                        <div class="form-group">
                            <label for="convert_unit_source"><abbr title="required">*</abbr><small> Source Unit</small></label>
                            <select name="convert_unit_source" id="convert_unit_source" class="form-control" required>
                                <option value="">-</option>
                                @foreach ($unit as $u)
                                    <option value="{{$u->code}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="convert_unit_target"><abbr title="required">*</abbr><small> Target Unit</small></label>
                            <select name="convert_unit_target" id="convert_unit_target" class="form-control" required>
                                <option value="">-</option>
                                @foreach ($unit as $u)
                                    <option value="{{$u->code}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="convert_unit_factor"><abbr title="required">*</abbr><small> Factor Unit</small></label>
                            <input type="number" step=".01" min="0.01" name="convert_unit_factor" id="convert_unit_factor" class="form-control" placeholder="0.01" required>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-info btn-sm">Create Conversion</button>
                            <button type="button" data-dismiss="modal" class="btn btn-seccondary btn-sm">Cancel</button>
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
        $(document).ready(function(){
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
                $('#new_ma_style').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        var id_fabricconst = $('#id_fabricconst').val();
                        $.ajax({
                        url:"{{ route('autocomplete.style') }}",
                        method:"POST",
                        data:{query:query, _token:_token, id_fabricconst},
                        success:function(data){
                            if (data!='') {
                                $('#new_ma_stylelist').fadeIn();
                                $('#new_ma_stylelist').html(data);
                                } else {
                                $('#new_ma_stylelist').fadeOut();
                                $('#new_ma_stylelist').empty();
                                $('#new_ma_style').val('');
                                }
                            }
                        });
                    }
                });
                $('#new_ma_number').keyup(function(){
                    var query = $(this).val();
                    if(query != '')
                    {
                        var _token = $('input[name="_token"]').val();
                        var id_fabricconst = $('#id_fabricconst').val();
                        $.ajax({
                        url:"{{ route('autocomplete.so_number') }}",
                        method:"POST",
                        data:{query:query, _token:_token, id_fabricconst},
                        success:function(data){
                            if (data!='') {
                                $('#new_ma_numberlist').fadeIn();
                                $('#new_ma_numberlist').html(data);
                                } else {
                                $('#new_ma_numberlist').fadeOut();
                                $('#new_ma_numberlist').empty();
                                $('#new_ma_number').val('');
                                }
                            }
                        });
                    }
                });

                $("#table_material tr").click(function(){
                    $("#table_material tr").css('background', '#FFFFFF');
                    $(this).css('background', '#F0E68C');
                });

                var importMaterial = document.getElementById('btn_import_material');
                importMaterial.addEventListener('click', function(){
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url: '/purchasing/acc_orders/get_material',
                        type: 'POST',
                        data: {_token: _token},
                        dataType: 'JSON',
                        success: function(res){
                            baris = '<table class="table table-bordered table-hover"><thead><tr><th></th><th>Order</th><th>Quotation</th><th>Style</th><th>Fab. Construct</th><th>Fab. Compost</th><th>Fab. Description</th><th>Budget</th><th>Delivery Date</th><th>Status</th><thead></tr></thead> <tbody id="import_material_tbody"></tbody></table>';

                            $('#import_material_body').html(baris);

                            row = '';
                            for(i=0; i<res.data.length; i++){
                                row += '<tr><td></td><td>'+res.data[i].customer+'</td><td>'+res.data[i].code_quotation+'</td><td>'+res.data[i].style+'</td><td></td><td></td><td></td><td></td><td>'+res.data[i].delivery_date+'</td><td></td></tr>'
                            }
                            $('#import_material_tbody').html(row);
                            console.log(res.data[0]);
                        }
                    });
                }, false);
            });

        function rupiah(angka)
        {
            var	number_string = angka.toString(),
                sisa 	= number_string.length % 3,
                rupiah 	= number_string.substr(0, sisa),
                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            // Cetak hasil
            return rupiah

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

        function pilihStyle($ls){
                var ls = $ls;
                var ls = $ls;
                $('#id_new_ma_style').val($('#id_sty'+ls).text());
                $('#new_ma_style').val($('#sty'+ls).text());
                $('#new_ma_stylelist').fadeOut();
        }

        function pilih_so_number($ls){
                var ls = $ls;
                var ls = $ls;
                $('#id_new_ma_number').val($('#id_so_number'+ls).text());
                $('#new_ma_number').val($('#so_number'+ls).text());
                $('#new_ma_numberlist').fadeOut();
        }

        function selectMaterial(id){
            $('#selected_id_poacc_material').val(id);
            var _token = $('input[name="_token"]').val();

            $("#table_material_br").html('');

            $.ajax({
                url: "/purchasing/acc_orders/material/{id}/edit",
                    method: "POST",
                    data: {_token: _token,id:id},
                    dataType: "JSON",
                    success: function(res){
                        var baris = '';
                        console.log(res.poacc_m_br);
                        for(var i=0; i < res.poacc_m_br.length; i++){
                            baris += '<tr>'+
                            '<td>'+res.poacc_m_br[i].color.name+'</td>'+
                            '<td>'+res.poacc_m_br[i].color.name+'</td>'+
                            '<td>'+res.poacc_m_br[i].size.name+'</td>'+
                            '<td>'+res.poacc_m_br[i].unit.name+'</td>'+
                            '<td>'+res.poacc_m_br[i].price+'</td>'+
                            '<td>'+res.poacc_m_br[i].quantity+'</td>'+
                            '<td>'+rupiah(res.poacc_m_br[i].price * res.poacc_m_br[i].quantity)+'</td>'+
                            '<td>'+res.poacc_m_br[i].quantity+'</td>'+
                            '<td><a href="#" onclick="confirmRound()">Round</a></td>'+
                            '</tr>;'

                        }
                        $('#table_material_br').append(baris);
                    }
            });
        }

        function confirmRound(){
            var confirmation = confirm("Lanjutkan untuk melakukan round?");
            if(confirmation){
                alert('rounded');
            } else {
                alert('round canceled');
            }
        }

        function getDetail(id)
        {
            var id = id;
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '/purchasing/acc_orders/{id}/edit',
                type: 'POST',
                data: {id: id, _token: _token},
                dataType: 'json',
                success: function(res) {
                    $('input[name="edit_id"]').val(res.po.id);
                    $('input[name="edit_number"]').val(res.po.number);
                    $('input[name="edit_order_date"]').val(res.po.order_date);
                    $('#edit_note').html(res.po.note);
                    $('input[name="edit_start_date"]').val(res.po.start_date);
                    $('input[name="edit_rounding_value"]').val(res.po.rounding_value);
                    $('input[name="edit_supplier"]').val(res.po.supplier);
                    $('input[name="edit_end_date"]').val(res.po.end_date);
                    $('input[name="edit_allowance_qty"]').val(res.po.allowance_qty);
                    // $('input[name="edit_currency"]').val(res.po.currency);
                    $('input[name="edit_price_term"]').val(res.po.price_term);
                    $('input[name="edit_exchange_rate"]').val(res.po.exchange_rate);
                    $('input[name="edit_payment_term"]').val(res.po.payment_term);
                    // $('input[name="edit_bank_charges"]').val(res.po.bank_charges);

                    var opt_currency = '';
                    var selected = '';
                    for(i=0;i<res.currency.length; i++){
                        if (res.currency[i] == res.po.currency){
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        opt_currency += '<option value="'+res.currency[i]+'"'+selected+'>'+res.currency[i]+'</option>'
                    }
                    $('#edit_currency').html(opt_currency);

                    var opt_bank_charges = '';
                    var selected = '';
                    for(i=0;i<res.bank_charges.length; i++){
                        if (res.bank_charges[i] == res.po.bank_charges){
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                        opt_bank_charges += '<option value="'+res.bank_charges[i]+'"'+selected+'>'+res.bank_charges[i]+'</option>'
                    }
                    $('#edit_bank_charges').html(opt_bank_charges);

                }
            });
        }

        function submit_material(perintah){
            if(perintah == 'update'){
                var id = $('#selected_id_poacc_material').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "/purchasing/acc_orders/material/{id}/edit",
                    method: "POST",
                    data: {_token:_token, id:id},
                    dataType: "JSON",
                    success: function(res){
                        console.log(res.poacc_m_br);
                        var baris = '';
                        $('#new_ma_tbody').html(baris);

                        $('#id_fabricconst').val(res.poacc_m.id_fabricconst);
                        $('#fabricconst').val(res.poacc_m.fabricconst.name);
                        $('#id_fabriccomp').val(res.poacc_m.id_fabriccomp);
                        $('#fabriccomp').val(res.poacc_m.fabriccomp.name);
                        $('#new_ma_fabdesc').val(res.poacc_m.fabric_desc);
                        $('#id_new_ma_number').val(res.poacc_m.id_sales_order);
                        $('#new_ma_number').val(res.poacc_m.salesorder.number);
                        $('#id_new_ma_style').val(res.poacc_m.id_style);
                        $('#new_ma_style').val(res.poacc_m.style.name);
                        $('#new_ma_budget').val(res.poacc_m.budget);
                        $('#new_ma_shipping_date').val(res.poacc_m.shipping_date);

                        var opt_material_type = '';
                        var selected = '';
                        for(var i=0; i<res.material_type.length; i++){
                            if (res.material_type[i] == res.poacc_m.material_type){
                                selected = 'selected';
                            } else {
                                selected = '';
                            }
                            opt_material_type += '<option value="'+res.material_type[i]+'"'+selected+'>'+res.material_type[i]+'</option>'
                        }
                        $('#new_ma_material_type').html(opt_material_type);

                        $('#ma_count').val(res.poacc_m_br.length);
                        for(var i=0; i<res.poacc_m_br.length; i++){
                           baris += '<tr>'+
                           '<td>'+
                           '<input type="hidden" id="id_color_'+(i+1)+'" name="id_color[]" value="'+res.poacc_m_br[i].id_color+'">'+
                           '<input class="form-control" type="text" name="new_ma_assort_color[]" id="color_'+(i+1)+'" onkeyup="keyUpColor('+(i+1)+')" value="'+res.poacc_m_br[i].color.name+'" autocomplete="off" required><div id="colorlist_'+(i+1)+'"></div>'+
                           '</td>'+
                           '<td>'+
                           '<input type="hidden" id="id_size_'+(i+1)+'" name="id_size[]" value="'+res.poacc_m_br[i].id_size+'">'+
                           '<input class="form-control" type="text" name="new_ma_assort_size[]" id="size_'+(i+1)+'" onkeyup="keyUpSize('+(i+1)+')" value="'+res.poacc_m_br[i].size.name+'" autocomplete="off" required><div id="sizelist_'+(i+1)+'"></div>'+
                           '</td>'+
                           '<td>'+
                           '<input type="hidden" id="id_unit_'+(i+1)+'" name="id_unit[]" value="'+res.poacc_m_br[i].id_unit+'">'+
                           '<input class="form-control" type="text" name="new_ma_assort_unit[]" id="unit_'+(i+1)+'" onkeyup="keyUpUnit('+(i+1)+')" value="'+res.poacc_m_br[i].unit.name+'" autocomplete="off" required><div id="unitlist_'+(i+1)+'"></div>'+
                           '</td>'+
                           '<td>'+
                           '<input class="form-control" type="number" name="new_ma_assort_price[]" id="new_ma_assort_price_'+(i+1)+'" onkeyup="calculateAmount()" value="'+res.poacc_m_br[i].price+'" required>'+
                           '</td>'+
                           '<td>'+
                           '<input class="form-control" type="number" name="new_ma_assort_quantity[]" id="new_ma_assort_quantity_'+(i+1)+'" onkeyup="calculateAmount()" value="'+res.poacc_m_br[i].quantity+'" required>'+
                           '</td>'+
                           '<td>'+
                           '<input class="form-control bg-warning" type="number" name="new_ma_assort_amount[]" id="new_ma_assort_amount_'+(i+1)+'" value="'+(res.poacc_m_br[i].price * res.poacc_m_br[i].quantity)+'" readonly>'+
                           '</td>'+
                           '<td>'+
                           '<button class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove(); minCount();">X</button>'+
                           '</td>'+
                           '</tr>'
                        }
                        $('#new_ma_tbody').append(baris);
                    }
                });

                $('#create_new_material').hide();
                $('#update_new_material').show();
            } else {
                document.getElementById("form_material_new").reset();
                $('#create_new_material').show();
                $('#update_new_material').hide();
            }
        }

        function materialUpdate(){
            var id = $('#selected_id_poacc_material').val();
            var _token = $('input[name="_token"]').val();
            var form = $('#form_material_new').serialize();

            $.ajax({
                url: "/purchasing/acc_orders/{id}/update",
                method: "POST",
                data: {form:form, _token:_token, id:id},
                dataType: "JSON",
                success: function(res){
                    window.location=res.url;
                }
            });
        }

        function materialDelete(){
            var checkconfirm = confirm('Lanjutkan untuk menghapus material?');
            if(checkconfirm){
                var id = $('#selected_id_poacc_material').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: "/purchasing/acc_orders/{id}/delete_material",
                    method: "POST",
                    data: {_token:_token, id:id},
                    dataType: "JSON",
                    success: function(res){
                        window.location=res.url;
                    }
                });
            }
        }

        function ma_add_row(){
            count = document.getElementById("ma_count").value;
            count++;

            baris = '<tr>'+
                '<td>'+'<input type="hidden" id="id_color_'+count+'" name="id_color[]"><input class="form-control" type="text" name="new_ma_assort_color[]" id="color_'+count+'" onkeyup="keyUpColor('+count+')" autocomplete="off" required><div id="colorlist_'+count+'"></div>'+' </td>'+
                // '<td>'+'<select class="form-control"><option>1</option> </select>'+' </td>'+
                '<td>'+'<input type="hidden" id="id_size_'+count+'" name="id_size[]"><input class="form-control" type="text" name="new_ma_assort_size[]" id="size_'+count+'" onkeyup="keyUpSize('+count+')" autocomplete="off" required><div id="sizelist_'+count+'"></div>'+' </td>'+
                '<td>'+'<input type="hidden" id="id_unit_'+count+'" name="id_unit[]"><input class="form-control" type="text" name="new_ma_assort_unit[]" id="unit_'+count+'" onkeyup="keyUpUnit('+count+')" autocomplete="off" required><div id="unitlist_'+count+'"></div>'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_price[]" id="new_ma_assort_price_'+count+'" onkeyup="calculateAmount()" required>'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_quantity[]" id="new_ma_assort_quantity_'+count+'" onkeyup="calculateAmount()" required>'+'</td>'+
                '<td>'+'<input class="form-control bg-warning" type="number" name="new_ma_assort_amount[]" id="new_ma_assort_amount_'+count+'" readonly>'+'</td>'+
                '<td>'+'<button class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove(); minCount();">X</button>'+'</td>' + '</tr>'

            $('#new_ma_tbody').append(baris);
            document.getElementById("ma_count").value = count;
        }

        function calculateAmount()
        {
            var count = document.getElementById("ma_count").value;

            for(var i=1; i <= count; i++){
                var price = $("#new_ma_assort_price_"+i).val();
                var quantity = $("#new_ma_assort_quantity_"+i).val();
                console.log(price +'/'+quantity);

                var amount  = price * quantity;
                $("#new_ma_assort_amount_"+i).val(amount);
            }
        }

        function minCount() {
            var count = document.getElementById("ma_count").value;
            count--;
            document.getElementById("ma_count").value=count;
        }

        function keyUpColor(index){
            var query = $('#color_'+index).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                url:"{{ route('autocomplete.colorInTable') }}",
                method:"POST",
                data:{query:query, _token:_token,index:index},
                success:function(data){
                    if (data!='') {
                        $('#colorlist_'+index).fadeIn();
                        $('#colorlist_'+index).html(data);
                        } else {
                        $('#colorlist_'+index).fadeOut();
                        $('#colorlist_'+index).empty();
                        $('#color_'+index).val('');
                        }
                    }
                });
            }
        }
        function pilihColorInTable(ls,index){
            $('#id_color_'+index).val($('#code_col'+ls+'_'+index).text());
            $('#color_'+index).val($('#col'+ls+'_'+index).text());
            $('#colorlist_'+index).fadeOut();
        }

        function keyUpSize(index){
            var query = $('#size_'+index).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                url:"{{ route('autocomplete.sizeInTable') }}",
                method:"POST",
                data:{query:query, _token:_token,index:index},
                success:function(data){
                    if (data!='') {
                        $('#sizelist_'+index).fadeIn();
                        $('#sizelist_'+index).html(data);
                        } else {
                        $('#sizelist_'+index).fadeOut();
                        $('#sizelist_'+index).empty();
                        $('#size_'+index).val('');
                        }
                    }
                });
            }
        }
        function pilihSizeInTable(ls,index){
            $('#id_size_'+index).val($('#size_id'+ls+'_'+index).text());
            $('#size_'+index).val($('#size_name'+ls+'_'+index).text());
            $('#sizelist_'+index).fadeOut();
        }


        function keyUpUnit(index){
            var query = $('#unit_'+index).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                url:"{{ route('autocomplete.UnitInTable') }}",
                method:"POST",
                data:{query:query, _token:_token,index:index},
                success:function(data){
                    if (data!='') {
                        $('#unitlist_'+index).fadeIn();
                        $('#unitlist_'+index).html(data);
                        } else {
                        $('#unitlist_'+index).fadeOut();
                        $('#unitlist_'+index).empty();
                        $('#unit_'+index).val('');
                        }
                    }
                });
            }
        }
        function pilihUnitInTable(ls,index){
            $('#id_unit_'+index).val($('#id_unit'+ls+'_'+index).text());
            $('#unit_'+index).val($('#unit'+ls+'_'+index).text());
            $('#unitlist_'+index).fadeOut();
        }


        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });

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
            $(document).on('click', '.pagination a', function(e) {
                var url = $(this).attr('href');
                getDatas($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });
    </script>
