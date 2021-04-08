@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class="">
    @foreach($header as $h)

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/quotation') }}">Quotation</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/quotation/view/'.$h->code) }}">{{$h->cust}} ( {{$h->style}} )</a>
        </li>
        <li class="breadcrumb-item active">Edit Quotation</li>
    </ol>

    <div class="card">
        <div class="card-header">
            Edit Quotation {{$h->cust}} ( {{$h->style}} )
        </div>
        <div class="card-body">
            <form method="post" action="/quotation/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="container">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="row ">
                                <label for="cust">Customer<span style="color: red"> *</span></label>
                                <input type="text" id="cust" name="cust" value="{{$h->cust}}"
                                    placeholder="Pilih Customer" class="form-control" required autocomplete="off">
                                <span>
                                    <div id="custList"></div>
                                </span>
                            </div>
                            <div class="row">
                                <label for="brand">Brand<span style="color: red"> *</span></label>
                                <input type="text" id="brand" name="brand" value="{{$h->brand}}"
                                    placeholder="Masukan Brand" class="form-control" required autocomplete="off">
                                <span>
                                    <div id="brandList"></div>
                                </span>
                            </div>
                            <div class="row">
                                <label for="season">Season<span style="color: red"> *</span></label>
                                <input type="text" id="season" name="season" value="{{$h->season}}"
                                    placeholder="Masukan Season" class="form-control" required>
                            </div>
                            <div class="row">
                                <label for="style">Style<span style="color: red"> *</span></label>
                                <input type="text" id="style" name="style" value="{{$h->style}}"
                                    placeholder="Pilih Style" class="form-control" required autocomplete="off">
                                <span>
                                    <div id="styleList"></div>
                                </span>
                            </div>
                            <div class="row">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="descript" name="description"
                                    placeholder="Isi Deskripsi Sesuai Tech Pack" cols="16"
                                    rows="5">{{$h->description}}</textarea>
                            </div>
                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <label for="bu">Business Unit<span style="color: red"> *</span></label>
                                <select id="bu" name="bu" class="form-control">
                                    <option selected value="{{$h->bu}}">{{$h->bu}}</option>
                                    <option value="BUSINESS UNIT 1">BU 1</option>
                                    <option value="BUSINESS UNIT 2">BU 2</option>
                                    <option value="BUSINESS UNIT 3">BU 3</option>
                                    <option value="BUSINESS UNIT 4">BU 4</option>
                                </select>
                            </div>
                            <div class="row">
                                <label for="forecast_qty">Forecast Qty</label>
                                <input type="number" id="forecast_qty" name="forecast_qty" placeholder="Forecast Qty"
                                    value="{{$h->forecast_qty}}" class="form-control input-intable">
                            </div>
                            <div class="row">
                                <label for="size_range">Size Range<span style="color: red"> *</span></label>
                                <input type="text" id="size_range" name="size_range" placeholder="Size Range"
                                    value="{{$h->size_range}}" class="form-control" required>
                            </div>
                            <div class="row">
                                <label for="delivery">Delivery</label>
                                <input type="date" id="delivery" name="delivery" placeholder="Delivery"
                                    value="{{$h->delivery}}" class="form-control">
                            </div>
                            <div class="row">
                                <label for="destination">Destination</label>
                                <input type="text" id="destination" name="destination" placeholder="Destination"
                                    value="{{$h->destination}}" class="form-control" autocomplete="off">
                                <span>
                                    <div id="countryList"></div>
                                </span>
                            </div>
                            <div class="row">
                                <label for="tgl_quot">Date Of Quote<span style="color: red"> *</span></label>
                                <input type="date" id="tgl_quot" value="{{$h->tgl_quot}}" name="tgl_quot"
                                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control" required
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-1">
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <label for="exchange_rate">Exchange Rate</label>
                                <input type="number" id="exchange_rate" placeholder="Nilai Tukar Saat Quotation Di Buat"
                                    name="exchange_rate" value="{{$h->exchange_rate}}" step="0.001"
                                    class="form-control input-intable">
                            </div>
                            <div class="row">
                                <label for="smv">SMV<span style="color: red"> *</span></label>
                                <input type="number" id="smv" name="smv" value="{{$h->smv}}" placeholder="SMV Dari IE"
                                    step="0.001" class="form-control input-intable" required>
                            </div>
                            <div class="row">
                                <label for="rate">Rate<span style="color: red"> *</span></label>
                                <input type="number" id="rate" name="rate" placeholder="Rate Standar 0.06"
                                    value="{{$h->rate}}" step="0.001" class="form-control input-intable" required>
                            </div>
                            <div class="row">
                                <label for="create_by">Created By<span style="color: red"> *</span></label>
                                <input type="text" readonly id="create_by_name" name="create_by_name"
                                    value="{{ $h->user['name'] }}" class="form-control" required>
                                <input type="hidden" id="create_by" name="create_by" value="{{ $h->create_by }}"
                                    required>
                                <input type="hidden" id="id_header" name="id_header" value="{{ $id_header }}" required>
                            </div>
                            <div class="row">
                                <label for="update_by">Update By</label>
                                <input type="text" readonly id="update_by_name" name="update_by_name"
                                    value="{{ Auth::user()->name }}" class="form-control" required>
                                <input type="hidden" readonly id="update_by" name="update_by"
                                    value="{{ Auth::user()->id }}" class="form-control" required>
                            </div>
                            <div class="row">
                                <label for="gmbr">Sketch</label>
                                <input type="file" accept="image/*" id="gmbr" name="gmbr[]" multiple name="gmbr"
                                    class="form-control">
                            </div><br>
                            <div class="row">
                                <label>
                                    <p align="right">Field dengan<span style="color: red"> *</span> Wajib di isi</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-auto">
                    <div class="row">
                        @foreach($h->quot_gambar as $gmbr)
                        <img src="{{ url($gmbr->file) }}" height="100" align="middle">&nbsp &nbsp
                        @endforeach
                    </div>
                </div>
                @endforeach

                <br>
                <table id="dataTable_f" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">FABRIC</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a id="btn_add_f" onclick="addrow('dataTable_f','f')" href="##"
                                        class="btn btn-primary"><i class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Fabrication</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="f">
                        <?php $no = 0; $total_f = 0;?>
                        @foreach($fabric as $f)
                        <?php
                          $no++;
                          $allowance_f      = $f->cons * (($f->allowance / 100)+1);
                          $freight_f        = $f->price * (($f->freight / 100)+1);
                          $subtotal_f       = $allowance_f * $freight_f;
                          $total_f          = $total_f + $subtotal_f;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $f->position }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="FABRIC" class="form-control  width-dynamic"
                                    style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $f->jenis_detail }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" style="min-width:350 !important" required
                                    value="{{ $f->description }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control width-dynamic" style="min-width:90 !important" required
                                    value="{{ $f->supplier }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($f->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_f_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($f->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_f_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($f->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_f_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_f,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_f_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($f->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_f_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($f->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_f_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_f,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_f_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_f,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_f" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Fabric</b></td>
                            <td class="td-input">
                                <input type="number" id="total_f" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_f,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <table id="dataTable_st" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">SPECIAL TRIMS</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a id="btn_add_st" onclick="addrow('dataTable_st','st')" href="##"
                                        class="btn btn-primary"><i class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Special Trims</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="st">
                        <?php $no = 0; $total_st = 0;?>
                        @foreach($special_trims as $st)
                        <?php
                          $no++;
                          $allowance_st      = $st->cons * (($st->allowance / 100)+1);
                          $freight_st        = $st->price * (($st->freight / 100)+1);
                          $subtotal_st       = $allowance_st * $freight_st;
                          $total_st          = $total_st + $subtotal_st;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $st->position }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="SPECIAL TRIMS"
                                    class="form-control  width-dynamic" style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $st->jenis_detail }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" class="form-control  width-dynamic"
                                    style="min-width:350 !important" required value="{{ $st->description }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control  width-dynamic" style="min-width:90 !important" required
                                    value="{{ $st->supplier }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($st->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_st_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($st->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_st_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($st->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_st_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_st,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_st_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($st->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_st_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($st->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_st_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_st,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_st_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_st,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_st" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Special Trims</b></td>
                            <td class="td-input">
                                <input type="number" id="total_st" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_st,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <table id="dataTable_t" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">TRIMS</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a id="btn_add_t" onclick="addrow('dataTable_t','t')" href="##"
                                        class="btn btn-primary"><i class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Trims / Accessories</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="t">
                        <?php $no = 0; $total_t = 0;?>
                        @foreach($trims as $t)
                        <?php
                          $no++;
                          $allowance_t      = $t->cons * (($t->allowance / 100)+1);
                          $freight_t        = $t->price * (($t->freight / 100)+1);
                          $subtotal_t       = $allowance_t * $freight_t;
                          $total_t          = $total_t + $subtotal_t;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $t->position,3 }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="TRIMS" class="form-control  width-dynamic"
                                    style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $t->jenis_detail,3 }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" class="form-control  width-dynamic"
                                    style="min-width:350 !important" required value="{{ $t->description,3 }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control  width-dynamic" style="min-width:90 !important" required
                                    value="{{ $t->supplier,3 }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($t->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_t_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($t->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_t_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($t->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_t_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_t,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_t_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($t->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_t_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($t->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_t_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_t,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_t_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_t,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_t" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Trims / Accessories</b></td>
                            <td class="td-input">
                                <input type="number" id="total_t" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_t,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <table id="dataTable_e" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">EMBELLISHMENT</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a id="btn_add_e" onclick="addrow('dataTable_e','e')" href="##"
                                        class="btn btn-primary"><i class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Embellishment</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="e">
                        <?php $no = 0; $total_e = 0;?>
                        @foreach($embellishment as $e)
                        <?php
                          $no++;
                          $allowance_e      = $e->cons * (($e->allowance / 100)+1);
                          $freight_e        = $e->price * (($e->freight / 100)+1);
                          $subtotal_e       = $allowance_e * $freight_e;
                          $total_e          = $total_e + $subtotal_e;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $e->position }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="EMBELLISHMENT"
                                    class="form-control  width-dynamic" style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $e->jenis_detail }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" class="form-control  width-dynamic"
                                    style="min-width:350 !important" required value="{{ $e->description }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control  width-dynamic" style="min-width:90 !important" required
                                    value="{{ $e->supplier }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($e->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_e_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($e->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_e_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($e->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_e_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_e,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_e_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($e->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_e_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($e->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_e_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_e,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_e_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_e,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_e" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Embellishment</b></td>
                            <td class="td-input">
                                <input type="number" id="total_e" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_e,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <table id="dataTable_w" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">WASHING</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a id="btn_add_w" onclick="addrow('dataTable_w','w')" href="##"
                                        class="btn btn-primary"><i class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Washing</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="w">
                        <?php $no = 0; $total_w = 0;?>
                        @foreach($washing as $w)
                        <?php
                          $no++;
                          $allowance_w      = $w->cons * (($w->allowance / 100)+1);
                          $freight_w        = $w->price * (($w->freight / 100)+1);
                          $subtotal_w       = $allowance_w * $freight_w;
                          $total_w          = $total_w + $subtotal_w;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $w->position }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="WASHING" class="form-control  width-dynamic"
                                    style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $w->jenis_detail }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" class="form-control  width-dynamic"
                                    style="min-width:350 !important" required value="{{ $w->description }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control  width-dynamic" style="min-width:90 !important" required
                                    value="{{ $w->supplier }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($w->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_w_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($w->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_w_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($w->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_w_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_w,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_w_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($w->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_w_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($w->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_w_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_w,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_w_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_w,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_w" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Washing</b></td>
                            <td class="td-input">
                                <input type="number" id="total_w" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_w,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <table id="dataTable_m" class="table-bordered table-hover  table-responsive ">
                    <thead>
                        <tr bgcolor="#94acf2">
                            <th colspan="13">MISCELLANEOUS</th>
                        </tr>
                        <tr bgcolor="#f2ea94" align="center">
                            <th>
                                <center><a onclick="addrow('dataTable_m','m')" href="##" class="btn btn-primary"><i
                                            class="icon-add"></i></a></center>
                            </th>
                            <th>Position</th>
                            <th>Miscelleneous</th>
                            <th>Description</th>
                            <th>Supplier</th>
                            <th>Width</th>
                            <th>Cons</th>
                            <th>Allow(%)</th>
                            <th>Allow</th>
                            <th>Price</th>
                            <th>Freight(%)</th>
                            <th>Freight</th>
                            <th>Subtotal Price</th>
                        </tr>
                    </thead>
                    <tbody id="m">
                        <?php $no = 0; $total_m = 0;?>
                        @foreach($miscellaneous as $m)
                        <?php
                          $no++;
                          $allowance_m      = $m->cons * (($m->allowance / 100)+1);
                          $freight_m        = $m->price * (($m->freight / 100)+1);
                          $subtotal_m       = $allowance_m * $freight_m;
                          $total_m          = $total_m + $subtotal_m;
                        ?>
                        <tr>
                            <td class="td-input">
                                <center>
                                    <a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##"
                                        class="btn btn-danger"><i class="icon-subtract"></i></a>
                                </center>
                            </td>
                            <td class="td-input">
                                <input type="text" name="position[]" placeholder="Posisi Item"
                                    class="form-control  width-dynamic" style="min-width:120 !important"
                                    value="{{ $m->position }}">
                            </td>
                            <td class="td-input">
                                <input type="hidden" name="jenis[]" value="MISCELLANEOUS"
                                    class="form-control  width-dynamic" style="min-width:70 !important" required>
                                <input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item"
                                    class="form-control  width-dynamic" style="min-width:140 !important" required
                                    value="{{ $m->jenis_detail }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="description[]"
                                    placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)"
                                    class="form-control  width-dynamic" class="form-control  width-dynamic"
                                    style="min-width:350 !important" required value="{{ $m->description }}">
                            </td>
                            <td class="td-input">
                                <input type="text" name="supplier[]" placeholder="Supplier"
                                    class="form-control  width-dynamic" style="min-width:90 !important" required
                                    value="{{ $m->supplier }}">
                            </td>
                            <td class="td-input">
                                <input type="number" name="width[]" step="0.001" class="form-control input-intable"
                                    value="{{ round($m->width,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="cons_m_{{$no}}" name="cons[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($m->cons,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="allowance_m_{{$no}}" name="allowance[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($m->allowance,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_allowance_m_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($allowance_m,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="price_m_{{$no}}" name="price[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($m->price,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="freight_m_{{$no}}" name="freight[]" step="0.001"
                                    class="form-control input-intable" required value="{{ round($m->freight,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="hasil_freight_m_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($freight_m,3) }}">
                            </td>
                            <td class="td-input">
                                <input type="number" id="subtotal_m_{{$no}}" step="0.001"
                                    class="form-control input-intable" readonly value="{{ round($subtotal_m,3) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr bgcolor="#97ace8">
                            <td class="td-input">
                                <center>
                                    <a id="calculate_m" onclick="calculate_all()" href="##" class="btn btn-success"><i
                                            class="icon-sync"></i></a>
                                </center>
                            </td>
                            <td colspan="11" align="right"><b>Total Miscelleneous</b></td>
                            <td class="td-input">
                                <input type="number" id="total_m" step="0.001" class="form-control input-intable"
                                    readonly value="{{ round($total_m,3) }}">
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <br>
                <div class="form-row">
                    <div class="col-md-7">
                        <table class="table table-hover table-striped table-bordered table-responsive ">
                            <tbody>
                                <?php $no = 0;?>
                                @foreach($header as $h)
                                <?php
                          $no++;
                          $c_m                        = $h->smv * $h->rate;
                          $total_cost                 = $c_m + $total_f + $total_st + $total_t + $total_e + $total_w + $total_m;
                          $handling                   = ($h->handling / 100) * $total_cost;
                          $total_cost_handling        = $total_cost + $handling;
                          $margin                     = ($h->margin / 100) * $total_cost_handling;
                          $total_cost_handling_margin = $total_cost_handling + $margin;
                          $sales_fee                  = ($h->sales_fee / 100) * $h->offer_price;
                          $offer_price_sales_fee      = $h->offer_price + $sales_fee;
                        ?>
                                <tr>
                                    <td colspan="11">CM (Cut / Make)</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="c_m" name="c_m"
                                                step="0.001" class="form-control input-intable" readonly
                                                value="{{ round($c_m,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Total Cost</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="total_cost"
                                                name="total_cost" step="0.001" class="form-control input-intable"
                                                readonly value="{{ round($total_cost,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Handling<span style="color: red"> *</span></td>
                                    <td class="td-input" bgcolor="#f2ea94">
                                        <div class="form-inline">
                                            <input type="number" style="width: 50px !important" id="handling"
                                                name="handling" step="0.001" class="form-control input-intable" required
                                                value="{{ round($h->handling,3) }}"> &nbsp % &nbsp
                                        </div>
                                    </td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="h_handling"
                                                name="h_handling" step="0.001" class="form-control input-intable"
                                                readonly value="{{ round($handling,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Total Cost + Handling</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="tc_handling"
                                                name="tc_handling" step="0.001" class="form-control input-intable"
                                                readonly value="{{ round($total_cost_handling,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Margin<span style="color: red"> *</span></td>
                                    <td class="td-input" bgcolor="#f2ea94">
                                        <div class="form-inline">
                                            <input type="number" style="width: 50px !important" id="margin"
                                                name="margin" step="0.001" class="form-control input-intable" required
                                                value="{{ round($h->margin,3) }}"> &nbsp % &nbsp
                                        </div>
                                    </td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="h_margin"
                                                name="h_margin" step="0.001" class="form-control input-intable" readonly
                                                value="{{ round($margin,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Total Cost + Handling + margin</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="tc_handling_margin"
                                                name="tc_handling_margin" step="0.001"
                                                class="form-control input-intable" readonly
                                                value="{{ round($total_cost_handling_margin,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Offer Price<span style="color: red"> *</span></td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#f2ea94">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="offer_price"
                                                name="offer_price" step="0.001" class="form-control input-intable"
                                                required value="{{ round($h->offer_price,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Sales Fee<span style="color: red"> *</span></td>
                                    <td class="td-input" bgcolor="#f2ea94">
                                        <div class="form-inline">
                                            <input type="number" style="width: 50px !important" id="sales_fee"
                                                name="sales_fee" step="0.001" class="form-control input-intable"
                                                required value="{{ round($h->sales_fee,3) }}"> &nbsp % &nbsp
                                        </div>
                                    </td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="h_sales_fee"
                                                name="h_sales_fee" step="0.001" class="form-control input-intable"
                                                readonly value="{{ round($sales_fee,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Offer Price + Sales Fee</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#49e372">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="op_sales_fee"
                                                name="op_sales_fee" step="0.001" class="form-control input-intable"
                                                readonly value="{{ round($offer_price_sales_fee ,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">Confirmed Price</td>
                                    <td></td>
                                    <td class="td-input" bgcolor="#f2ea94">
                                        <div class="form-inline">&nbsp $ &nbsp
                                            <input type="number" style="width: 60px !important" id="confirm_price"
                                                name="confirm_price" step="0.001" class="form-control input-intable"
                                                value="{{ round($h->confirm_price ,3) }}">
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1"><br></div>
                    <div class="col-md-auto">
                        <div class="form-group">
                            <p align="right"><a href="##" onclick="calculate_all()" id="btn_calculate"
                                    class="btn btn-primary"><i class="icon-sync"></i> Calculate</a></p>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="form-group">
                            <p align="right"><input type="submit" class="btn btn-success" value="Save Quotation"></p>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    var real_f=1,real_st=1,real_t=1,real_e=1,real_w=1,real_m=1;

  $(document).ready(function(){
    //autosize texbox

    real_f = document.getElementById('dataTable_f').rows.length;
    real_st = document.getElementById('dataTable_st').rows.length;
    real_t = document.getElementById('dataTable_t').rows.length;
    real_e = document.getElementById('dataTable_e').rows.length;
    real_w = document.getElementById('dataTable_w').rows.length;
    real_m = document.getElementById('dataTable_m').rows.length;

    $.fn.textWidth = function(text, font) {

      if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);

      $.fn.textWidth.fakeEl.text(text || this.val() || this.text() || this.attr('placeholder')).css('font', font || this.css('font'));

      return $.fn.textWidth.fakeEl.width();
    };

    $('.width-dynamic').on('input', function() {
      var inputWidth = $(this).textWidth();
      $(this).css({
        width: inputWidth
      })
    }).trigger('input');
    //end autosize textbox

    //autocomplete
    $('#style').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"{{ route('autocomplete.style') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
          if (data!='') {
            $('#styleList').fadeIn();
            $('#styleList').html(data);
          } else {
            $('#styleList').fadeOut();
            $('#styleList').empty();
            $('#style').val('');
          }
        }
      });
     }
   });

    $('#cust').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"{{ route('autocomplete.customer') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
          if (data!='') {
            $('#custList').fadeIn();
            $('#custList').html(data);
          } else {
            $('#custList').fadeOut();
            $('#custList').empty();
            $('#cust').val('');
          }
        }
      });
     }
   });

    $('#brand').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"{{ route('autocomplete.brand') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
          if (data!='') {
            $('#brandList').fadeIn();
            $('#brandList').html(data);
          } else {
            $('#brandList').fadeOut();
            $('#brandList').empty();
            $('#brand').val('');
          }
        }
      });
     }
   });

    $('#destination').keyup(function(){
      var query = $(this).val();
      if(query != '')
      {
       var _token = $('input[name="_token"]').val();
       $.ajax({
        url:"{{ route('autocomplete.country') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
          if (data!='') {
            $('#countryList').fadeIn();
            $('#countryList').html(data);
          } else {
            $('#countryList').fadeOut();
            $('#countryList').empty();
            $('#destination').val('');
          }
        }
      });
     }
   });
  //end autocomplete

  });

  //function for autocomplete
  function pilihStyle($ls){
    var ls = $ls;
    $('#style').val($('#sty'+ls).text());
    $('#styleList').fadeOut();
  }

  function pilihCustomer($ls){
    var ls = $ls;
    var ls = $ls;
    $('#cust').val($('#cust'+ls).text());
    $('#custList').fadeOut();
  }

  function pilihBrand($ls){
    var ls = $ls;
    var ls = $ls;
    $('#brand').val($('#br'+ls).text());
    $('#brandList').fadeOut();
  }

  function pilihCountry($ls){
    var ls = $ls;
    var ls = $ls;
    $('#destination').val($('#name'+ls).text());
    $('#countryList').fadeOut();
  }
//end function for autocomplete

  function addrow($t,$b) {
    var t = $t;
    var b = $b;
    var table = document.getElementById(t);
    var count =0;
    var jenis='';
    var frg=0,alw=0;
    if (b=='f') {
      jenis = 'FABRIC';
      real_f=real_f + 1;
      count = real_f;
      alw   =5;
      frg   =2;
    } else if (b=='st'){
      jenis = 'SPECIAL TRIMS';
      real_st=real_st + 1;
      count = real_st;
      alw   =3;
      frg   =2;
    } else if (b=='t'){
      jenis = 'TRIMS';
      real_t=real_t + 1;
      count = real_t;
      alw   =3;
      frg   =2;
    } else if (b=='e'){
      jenis = 'EMBELLISHMENT';
      real_e=real_e + 1;
      count = real_e;
      alw   =5;
      frg   =2;
    } else if (b=='w'){
      jenis = 'WASHING';
      real_w=real_w + 1;
      count = real_w;
      alw   =5;
      frg   =2;
    } else if (b=='m'){
      jenis = 'MISCELLANEOUS';
      real_m=real_m + 1;
      count = real_m;
      alw   =5;
      frg   =2;
    }

    $('#'+b).append(
                 '<tr>'
                  + '<td class="td-input"> '
                 + '<center>'
                 + '<a id="remove_btn" onclick="$(this).parent().parent().parent().remove();" href="##" class="btn btn-danger"><i class="icon-subtract"></i></a>'
                 + '</center>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="text" name="position[]" placeholder="Posisi Item" class="form-control  width-dynamic" style="min-width:120 !important">'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="hidden" name="jenis[]" value="'+jenis+'" class="form-control  width-dynamic" style="min-width:70 !important" required>'
                 + '<input type="text" name="jenis_detail[]" placeholder="Jenis / Nama Item" class="form-control  width-dynamic" style="min-width:140 !important" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="text" name="description[]" placeholder="keterangan lengkap (komposisi, gramasi, finishing, dll)" class="form-control  width-dynamic" class="form-control  width-dynamic" style="min-width:350 !important" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="text" name="supplier[]" placeholder="Supplier" class="form-control  width-dynamic" style="min-width:90 !important" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" name="width[]" step="0.001" class="form-control input-intable">'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="cons_'+b+'_'+count+'" name="cons[]" step="0.001" class="form-control input-intable" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="allowance_'+b+'_'+count+'" value='+alw+' name="allowance[]" step="0.001" class="form-control input-intable" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="hasil_allowance_'+b+'_'+count+'" step="0.001" class="form-control input-intable" readonly>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="price_'+b+'_'+count+'" name="price[]" step="0.001" class="form-control input-intable" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="freight_'+b+'_'+count+'" name="freight[]" value='+frg+' step="0.001" class="form-control input-intable" required>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="hasil_freight_'+b+'_'+count+'" step="0.001" class="form-control input-intable" readonly>'
                 + '</td>'
                 + '<td class="td-input">'
                 + '<input type="number" id="subtotal_'+b+'_'+count+'" step="0.001" class="form-control input-intable" readonly>'
                 + '</td>'
                 + '</tr>'
       );
  }


  function calculate_per_table($t,$b){
    var t = $t;
    var b = $b;
    var table = document.getElementById(t);

    var tot_tabel = document.getElementById('total_'+b);
    tot_tabel.readOnly = false;

    var cons=0,allow=0,h_allow=0,price=0,freight=0,h_freight=0,item_total=0,total_tabel=0;

    if (b=='f') {
      count = real_f;
    } else if (b=='st'){
      count = real_st;
    } else if (b=='t'){
      count = real_t;
    } else if (b=='e'){
      count = real_e;
    } else if (b=='w'){
      count = real_w;
    } else if (b=='m'){
      count = real_m;
    }
      for (var x =1; x <= count; x++) {
        var cons_   = document.getElementById('cons_'+b+'_'+x);
        var allow_  = document.getElementById('allowance_'+b+'_'+x);
        var price_  = document.getElementById('price_'+b+'_'+x);
        var freight_= document.getElementById('freight_'+b+'_'+x);

        var hallow  = document.getElementById('hasil_allowance_'+b+'_'+x);
        var hfreight= document.getElementById('hasil_freight_'+b+'_'+x);
        var subtot  = document.getElementById('subtotal_'+b+'_'+x);

        if (cons_) {
          hallow.readOnly = false;
          hfreight.readOnly = false;
          subtot.readOnly = false;

          cons        = cons_.value;
          allow       = allow_.value;
          price       = price_.value;
          freight     = freight_.value;

          h_allow     = cons * ((allow / 100)+1);
          h_freight   = price * ((freight / 100)+1);
          item_total  = h_allow * h_freight;
          total_tabel = total_tabel + item_total;

          hallow.value    = h_allow.toFixed(3);
          hfreight.value  = h_freight.toFixed(3);
          subtot.value    = item_total.toFixed(3);
          hallow.readOnly = true;
          hfreight.readOnly = true;
          subtot.readOnly = true;
        }
      }

        tot_tabel.value=total_tabel.toFixed(3);
        tot_tabel.readOnly = true;
  }

  function calculate_all() {
    calculate_per_table('dataTable_f','f');
    calculate_per_table('dataTable_st','st');
    calculate_per_table('dataTable_t','t');
    calculate_per_table('dataTable_e','e');
    calculate_per_table('dataTable_w','w');
    calculate_per_table('dataTable_m','m');
    calculate_cost();
  }

  var total_old=0;

  function calculate_cost() {

    var smv=0,rate=0;
    var tot_f=0,tot_st=0,tot_t=0,tot_e=0,tot_w=0,tot_m=0;
    var prsn_handling=0,prsn_margin=0,prsn_sales_fee=0,offer_price=0;
    var cm=0,total_cost=0,handling=0,total_cost_handling=0,margin=0,total_cost_handling_margin=0,sales_fee=0,offer_price_sales_fee=0;

    var smv       = document.getElementById('smv').value;
    var rate      = document.getElementById('rate').value;

    var tot_f     = parseFloat(document.getElementById('total_f').value, 10);
    var tot_st    = parseFloat(document.getElementById('total_st').value, 10);
    var tot_t     = parseFloat(document.getElementById('total_t').value, 10);
    var tot_e     = parseFloat(document.getElementById('total_e').value, 10);
    var tot_w     = parseFloat(document.getElementById('total_w').value, 10);
    var tot_m     = parseFloat(document.getElementById('total_m').value, 10);

    var prsn_handling     = parseFloat(document.getElementById('handling').value, 10);
    var prsn_margin       = parseFloat(document.getElementById('margin').value, 10);
    var prsn_sales_fee    = parseFloat(document.getElementById('sales_fee').value, 10);

    var c_m                        = smv * rate
    var total_cost                 = c_m + tot_f + tot_st + tot_t + tot_e + tot_w + tot_m;
    var handling                   = (prsn_handling / 100) * total_cost;
    var total_cost_handling        = total_cost + handling;
    var margin                     = (prsn_margin / 100) * total_cost_handling;
    var total_cost_handling_margin = total_cost_handling + margin;

    if (total_cost_handling_margin.toFixed(3) != total_old) {
      document.getElementById('offer_price').value = Math.round(total_cost_handling_margin);
      var offer_price       = parseFloat(document.getElementById('offer_price').value, 10);
    } else {
      var offer_price       = parseFloat(document.getElementById('offer_price').value, 10);
    }

    var sales_fee                  = (prsn_sales_fee / 100) * offer_price;
    var offer_price_sales_fee      = offer_price + sales_fee;

    var txt_cm      = document.getElementById('c_m');
    var txt_tc      = document.getElementById('total_cost');
    var txt_h       = document.getElementById('h_handling');
    var txt_tc_h    = document.getElementById('tc_handling');
    var txt_m       = document.getElementById('h_margin');
    var txt_tc_h_m  = document.getElementById('tc_handling_margin');
    var txt_s_f     = document.getElementById('h_sales_fee');
    var txt_op_s_f  = document.getElementById('op_sales_fee');

    txt_cm.readOnly = false;
    txt_tc.readOnly = false;
    txt_h.readOnly = false;
    txt_tc_h.readOnly = false;
    txt_m.readOnly = false;
    txt_tc_h_m.readOnly = false;
    txt_s_f.readOnly = false;
    txt_op_s_f.readOnly = false;

    txt_cm.value      = c_m.toFixed(3);
    txt_tc.value      = total_cost.toFixed(3);
    txt_h.value       = handling.toFixed(3);
    txt_tc_h.value    = total_cost_handling.toFixed(3);
    txt_m.value       = margin.toFixed(3);
    txt_tc_h_m.value  = total_cost_handling_margin.toFixed(3);
    txt_s_f.value     = sales_fee.toFixed(3);
    txt_op_s_f.value  = offer_price_sales_fee.toFixed(3);

    txt_cm.readOnly = true;
    txt_tc.readOnly = true;
    txt_h.readOnly = true;
    txt_tc_h.readOnly = true;
    txt_m.readOnly = true;
    txt_tc_h_m.readOnly = true;
    txt_s_f.readOnly = true;
    txt_op_s_f.readOnly = true;

    total_old = total_cost_handling_margin.toFixed(3);
  }
</script>
