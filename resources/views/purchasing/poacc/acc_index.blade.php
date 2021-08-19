@extends('layouts.app')

@section('content')
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
                    <div class="col-sm-7">: {{$acc->exchange_rate}}</div>
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
                    <a id="btn_new_material" class="btn btn-default btn-sm" href="#modal_material_new"
                        data-toggle="modal" role="button"><small>New Material</small></a>
                    <a href="#modal_import_material" data-toggle="modal" class="btn btn-default btn-sm"
                        id="btn_import_material"><small>Import
                            Material</small></a>
                    <a href="#" class="btn btn-default btn-sm"><small>Sample Import Material</small></a>
                    <a href="#" class="btn btn-default btn-sm"><small>Convert Unit</small></a>
                    <a href="#" class="btn btn-default btn-sm"><small>Edit All Requirements</small></a>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-sm-12">
                    <a href="#" data-toggle="modal" class="btn btn-success btn-sm"><small>Select All</small></a>
                    <a href="#" class="btn btn-warning btn-sm"><small>Unselect All</small></a>
                    <a href="#" class="btn btn-primary btn-sm"><small>Edit Material</small></a>
                    <a href="#" class="btn btn-danger btn-sm"><small>Delete Detail</small></a>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered table-hover">
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
                        <th>actions</th>
                    </tr>
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
                </table>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="card mt-20">
            <div class="card-body">
                <a href="#" data-toggle="modal" class="btn btn-default btn-sm"><small>Convert Unit</small></a>
                <div class="row mt-2">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Source</th>
                            <th>Target</th>
                            <th>Factor</th>
                            <th></th>
                        </tr>
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
                    <form action="#" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>New Material</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabricconst">Fabric Construct</label>
                                            <input type="hidden" id="id_fabricconst" type="text"
                                                class="form-control @error('id_fabricconst') is-invalid @enderror"
                                                name="id_fabricconst" value="{{ old('id_fabricconst') }}"
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
                                        <label for="new_ma_number">Order Number</label>
                                        <input type="text" name="new_ma_number" id="new_ma_number" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_ma_budget">Budget</label>
                                        <input type="number" name="new_ma_budget" id="new_ma_budget"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label for="fabriccomp">Fabric Compost</label>
                                            <input type="hidden" id="id_fabriccomp" type="text"
                                                class="form-control @error('id_fabriccomp') is-invalid @enderror"
                                                name="id_fabriccomp" value="{{ old('id_fabriccomp') }}"
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
                                            <input id="style" type="text"
                                                class="form-control @error('style') is-invalid @enderror" name="style"
                                                value="{{ old('style') }}" autocomplete="off">
                                            <span>
                                                <div id="stylelist"></div>
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
                                        <input type="date" name="new_ma_fabdesc" id="new_ma_fabdesc"
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
                                        onclick="ma_add_row()"><small>add
                                            item</small></button>
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
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                $('#style').keyup(function(){
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
                                $('#stylelist').fadeIn();
                                $('#stylelist').html(data);
                                } else {
                                $('#stylelist').fadeOut();
                                $('#stylelist').empty();
                                $('#style').val('');
                                }
                            }
                        });
                    }
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
                $('#style').val($('#sty'+ls).text());
                $('#stylelist').fadeOut();
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

        function ma_add_row(){
            count = document.getElementById("ma_count").value;
            count++;

            baris = '<tr>'+
                '<td>'+'<input class="form-control" type="text" name="new_ma_assort_color[]" id="new_ma_assort_color_'+count+'">'+' </td>'+
                // '<td>'+'<select class="form-control"><option>1</option> </select>'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_size[]" id="new_ma_assort_size_'+count+'">'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_unit[]" id="new_ma_assort_unit_'+count+'">'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_price[]" id="new_ma_assort_price_'+count+'">'+' </td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_quantity[]"="new_ma_assort_quantity_'+count+'">'+'</td>'+
                '<td>'+'<input class="form-control" type="number" name="new_ma_assort_amount[]"="new_ma_assort_amount_'+count+'">'+'</td>'+
                '<td>'+'<button class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove(); minCount();">X</button>'+'</td>' + '</tr>'

            $('#new_ma_tbody').append(baris);
            document.getElementById("ma_count").value = count;
        }

        function minCount() {
            var count = document.getElementById("ma_count").value;
            count--;
            document.getElementById("ma_count").value=count;
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
