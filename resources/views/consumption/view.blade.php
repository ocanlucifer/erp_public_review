@extends('layouts.app')

@section('content')

<!-- <div class="container"> -->
<div class="">

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{url('/consumption')}}">Consumption</a></li>
        <li class="breadcrumb-item active">{{$cons->code}}</li>
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
            Detail Consumption
        </div>
        <div class="card-body text-size-small">
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Number</b></div>
                    <div class="col-sm-8">: {{$cons->code}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Garment Net Price</b></div>
                    <div class="col-sm-8">: {{round($cons->net_price,3)}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Marker Production</b></div>
                    <div class="col-sm-8">: {{$cons->number_mp}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Sales Order Number</b></div>
                    <div class="col-sm-8">: </div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Net Sales</b></div>
                    <div class="col-sm-8">: ????</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Size Tengah</b></div>
                    <div class="col-sm-8">: {{$cons->size_tengah}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Customer</b></div>
                    <div class="col-sm-8">: {{$cons->customer}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>% PO</b></div>
                    <div class="col-sm-8">: ???</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>state</b></div>
                    <div class="col-sm-8">: {{$cons->status}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Style</b></div>
                    <div class="col-sm-8">: {{$cons->styles['name']}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Consumption Per Dz</b></div>
                    <div class="col-sm-8">: ???</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Created By</b></div>
                    <div class="col-sm-8">: {{$cons->created_by}}</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Quotation</b></div>
                    <div class="col-sm-8">: {{$cons->code_quotation}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Budget</b></div>
                    <div class="col-sm-8">: ???</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Updated By</b></div>
                    <div class="col-sm-8">: {{$cons->updated_by}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Delivery Date</b></div>
                    <div class="col-sm-8">: {{date('d-m-Y', strtotime($cons->delivery_date))}}</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>Budget Status</b></div>
                    <div class="col-sm-8">: not available</div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>
                            @if ($cons->state == 'PENDING' || $cons->state == 'CONFIRMED')
                            Confirmed By
                            @elseif ($cons->state == 'UNCONFIRMED')
                            Unconfirmed By
                            @endif
                        </b>
                    </div>
                    <div class="col-sm-8">: {{$cons->confirmed_by}}</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="col-sm-4"><b>References Date</b></div>
                    <div class="col-sm-8">: {{$cons->references_date}}</div>
                </div>
            </div>

            <div class="mt-3">
                <a href="/consumption" class="btn btn-secondary btn-sm">Back</a>
                @if ($cons->status == "PENDING" || $cons->status == "UNCONFIRMED")
                <a href="/consumption/edit/{{$cons->id}}" class="btn btn-primary btn-sm">Edit</a>
                <a href="#" class="btn btn-warning btn-sm"
                    onclick="return confirm('Anda yakin untuk konfirmasi?')">Confirm</a>
                @else
                <a href="#" class="btn btn-danger btn-sm"
                    onclick="return confirm('Anda yakin untuk membatalkan konfirmasi?')">Unconfirm</a>
                @endif

                <a href="#" id="" class="btn btn-primary btn-sm">Print</a>
                <a href="#" id="" class="btn btn-primary btn-sm">Purchase Request</a>
            </div>
            <br>
        </div>
    </div>
<!-- start fabric table -->
    <div class="card mt-3">
        <div class="card-header">
           <a href="#" class="btn btn-primary btn-sm">NEW FABRIC CONSUMPTION</a>
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_fab as $consfab)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$consfab->fabricconst['name']}} {{$consfab->fabriccomp['name']}} {{$consfab->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="">New Item</a>

                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>KOMPONEN</th>
                            <th>LEBAR</th>
                            <th>CONS BUDGET</th>
                            <th>CONS MARKER</th>
                            <th>EFISIENSI MARKER</th>
                            <th>QTY UNIT</th>
                            <th>TOL (%)</th>
                            <th>QTY UNIT + TOL</th>
                            <th>QTY SAMPLE</th>
                            <th>QTY PURCH</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                        </tr>
                    </tbody>
                    <tbody>
                        @foreach ($consfab->ConsSupplier as $consfabsup)
                        <tr>
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$consfabsup->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($consfabsup->FabItem as $fabitem)
                        <tr>
                            <td>{{$fabitem->fab_color['name']}}</td>
                            <td>{{round($fabitem->total_qty,2)}}</td>
                            <td>{{$fabitem->komponen}}</td>
                            <td>{{round($fabitem->width,2)}} {{$fabitem->w_unit}}</td>
                            <td>{{round($fabitem->kons_budget,2)}}</td>
                            <td>{{round($fabitem->kons_marker,2)}}</td>
                            <td>{{round($fabitem->kons_efi,2)}}</td>
                            <td>{{round($fabitem->qty_unit,2)}}</td>
                            <td>{{round($fabitem->tole,2)}}</td>
                            <td>{{round($fabitem->qty_unit_tole,2)}}</td>
                            <td>{{round($fabitem->qty_sample,2)}}</td>
                            <td>{{round($fabitem->qty_purch,2)}}</td>
                            <td>{{round($fabitem->budget_price,2)}}</td>
                            <td>{{round($fabitem->supplier_price,2)}}</td>
                            <td>{{$fabitem->unit}}</td>
                            <td>{{round($fabitem->amount,2)}}</td>
                            <td>{{round($fabitem->amount_freight,2)}}</td>
                        </tr>
                        @endforeach
                        <tr style="background-color: #a2b8a6; ">
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('total_qty'),2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('kons_marker'),2)}}</b></td>
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('qty_unit'),2)}}</b></td>
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('qty_unit_tole'),2)}}</b></td>
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('qty_purch'),2)}}</b></td>
                            <td></td>
                            <td>{{round($consfabsup->FabItem->sum('supplier_price'),2)}}</td></td>
                            <td></td>
                            <td><b>{{round($consfabsup->FabItem->sum('amount'),2)}}</b></td>
                            <td><b>{{round($consfabsup->FabItem->sum('amount_freight'),2)}}</b></td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            @endforeach
        </div>
    </div>
<!-- end fabric table -->

<!-- start collar table -->
    <div class="card mt-3">
        <div class="card-header">
           <a href="#" class="btn btn-info btn-sm">NEW COLLAR CONSUMPTION</a>
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_collar as $conscollar)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$conscollar->fabricconst['name']}} {{$conscollar->fabriccomp['name']}} {{$conscollar->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="">New Item</a>

                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>TOL (%)</th>
                            <th>DIMENSION</th>
                            <th>SIZE</th>
                            <th>TOTAL</th>
                            <th>TOTAL TOLERANCE</th>
                            <th>TOTAL ROUNDED</th>
                            <th>KG/PCS</th>
                            <th>TOTAL QTY UNIT</th>
                            <th>QTY UNIT</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                        </tr>
                    </tbody>
                    <tbody>
                        @foreach ($conscollar->ConsSupplier as $conscollar)
                        <tr>
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$conscollar->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($conscollar->collarcuffItem as $collaritem)
                        <tr>
                            <td>{{$collaritem->fab_color['name']}}</td>
                            <td>{{round($collaritem->total_qty,2)}}</td>
                            <td>{{round($collaritem->tole,2)}}</td>
                            <td>{{$collaritem->dimension}}</td>
                            <td>{{$collaritem->size}}</td>
                            <td>{{round($collaritem->total,2)}}</td>
                            <td>{{round($collaritem->total_tolerance,2)}}</td>
                            <td>{{round($collaritem->total_rounded,2)}}</td>
                            <td>{{round($collaritem->qty_unit,2)}}</td>
                            <td>{{round($collaritem->total_qty_unit_pcs,2)}}</td>
                            <td>{{round($collaritem->total_qty_unit,2)}}</td>
                            <td>{{round($collaritem->budget_price,2)}}</td>
                            <td>{{round($collaritem->supplier_price,2)}}</td>
                            <td>{{$collaritem->unit}}</td>
                            <td>{{round($collaritem->amount,2)}}</td>
                            <td>{{round($collaritem->amount_freight,2)}}</td>
                        </tr>
                        @endforeach
                        <tr style="background-color: #a2b8a6; ">
                            <td></td>
                            <td><b>{{round($conscollar->collarcuffItem->sum('total_qty'),2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{round($conscollar->collarcuffItem->sum('total_qty_unit_pcs'),2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td>{{round($conscollar->collarcuffItem->sum('supplier_price'),2)}}</td></td>
                            <td></td>
                            <td><b>{{round($conscollar->collarcuffItem->sum('amount'),2)}}</b></td>
                            <td><b>{{round($conscollar->collarcuffItem->sum('amount_freight'),2)}}</b></td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end collar table -->

    <!-- start cuff table -->
    <div class="card mt-3">
        <div class="card-header">
           <a href="#" class="btn btn-danger btn-sm">NEW CUFF CONSUMPTION</a>
        </div>
        <div class="card-body text-size-small">
            @foreach ($cons_cuff as $conscuff)
            <div class="table-responsive table-bordered">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="btn-light dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$conscuff->fabricconst['name']}} {{$conscuff->fabriccomp['name']}} {{$conscuff->description}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="">New Item</a>

                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    </thead>

                    <tbody id="view">
                        <tr>
                            <th></th>
                            <th>TOTAL QTY</th>
                            <th>TOL (%)</th>
                            <th>DIMENSION</th>
                            <th>SIZE</th>
                            <th>TOTAL</th>
                            <th>TOTAL TOLERANCE</th>
                            <th>TOTAL ROUNDED</th>
                            <th>KG/PCS</th>
                            <th>TOTAL QTY UNIT</th>
                            <th>QTY UNIT</th>
                            <th>HARGA BUDGET</th>
                            <th>HARGA SUPPLIER</th>
                            <th>UNIT</th>
                            <th>AMOUNT</th>
                            <th>AMOUNT + FREIGHT</th>
                        </tr>
                    </tbody>
                    <tbody>
                        @foreach ($conscuff->ConsSupplier as $conscuff)
                        <tr>
                            <td colspan="17">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        {{$conscuff->supplier['nama']}}
                                    </button>
                                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
                                        @if ($cons->status == "UNCONFIRMED" || $cons->status == "PENDING")
                                        <a class="dropdown-item"
                                            href="">Edit</a>
                                        <a class="dropdown-item" href=""
                                            onclick="return confirm('Lanjutkan untuk hapus?')">Destroy</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach ($conscuff->collarcuffItem as $collaritem)
                        <tr>
                            <td>{{$collaritem->fab_color['name']}}</td>
                            <td>{{round($collaritem->total_qty,2)}}</td>
                            <td>{{round($collaritem->tole,2)}}</td>
                            <td>{{$collaritem->dimension}}</td>
                            <td>{{$collaritem->size}}</td>
                            <td>{{round($collaritem->total,2)}}</td>
                            <td>{{round($collaritem->total_tolerance,2)}}</td>
                            <td>{{round($collaritem->total_rounded,2)}}</td>
                            <td>{{round($collaritem->qty_unit,2)}}</td>
                            <td>{{round($collaritem->total_qty_unit_pcs,2)}}</td>
                            <td>{{round($collaritem->total_qty_unit,2)}}</td>
                            <td>{{round($collaritem->budget_price,2)}}</td>
                            <td>{{round($collaritem->supplier_price,2)}}</td>
                            <td>{{$collaritem->unit}}</td>
                            <td>{{round($collaritem->amount,2)}}</td>
                            <td>{{round($collaritem->amount_freight,2)}}</td>
                        </tr>
                        @endforeach
                        <tr style="background-color: #a2b8a6; ">
                            <td></td>
                            <td><b>{{round($conscuff->collarcuffItem->sum('total_qty'),2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>{{round($conscuff->collarcuffItem->sum('total_qty_unit_pcs'),2)}}</b></td>
                            <td></td>
                            <td></td>
                            <td>{{round($conscuff->collarcuffItem->sum('supplier_price'),2)}}</td></td>
                            <td></td>
                            <td><b>{{round($conscuff->collarcuffItem->sum('amount'),2)}}</b></td>
                            <td><b>{{round($conscuff->collarcuffItem->sum('amount_freight'),2)}}</b></td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
            </div>
            @endforeach
        </div>
    </div>
    <!-- end cuff table -->


</div>

</div>

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
        }

        // $(document).on("click", "#batal_newdetail", function(){
        // function batalDetail(){
            // var bataldetail = document.getElementById("#detail-ass-tbody");
            // bataldetail.innerHTML = '';
        // }
        // });

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

                    var id_mcpt = $(this).data("mcptid");
                    $("#id_type").val(id_mcpt);

                    // $("#id_type").val(id_type);
                    // $("#detail_size").val(size);
                    // $("#detail_qty").val(qty);
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

    function assort_cal(){
        // mendapatkan total skala secara otomatis
        var index_assort = document.getElementById('index_assort').value;
        var tot_ass_scale = 0;
        var tot_ass_scales = 0;

        for(i = 0; i < index_assort; i++){ var ass_qtyws=document.getElementById("input_det_qty_"+i).value; var
            ass_scale = document.getElementById("input_det_scale_"+i).value; var ass_scales=ass_qtyws * ass_scale;
            document.getElementById("input_det_scales_"+i).value=ass_scales;
            tot_ass_scale += parseInt(ass_scale);
            tot_ass_scales = tot_ass_scales + ass_scales;
        }
        document.getElementById("total_skala").value = tot_ass_scale;
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
        $(".form-detail").keyup(function(){

            var panjang = document.getElementById('panjang_m').value;
            var tole_panjang = document.getElementById('tole_pjg_m').value;
            var lebar = document.getElementById('lebar_m').value;
            var tole_lebar = document.getElementById('tole_lbr_m').value;
            var gramasi = document.getElementById('gramasi').value;
            var skala = document.getElementById('total_skala').value;
            var jml_ampar = document.getElementById('jml_ampar').value;
            // var detail_scale = document.getElementById('total_skala').value;

            // Perhitungan Lebar (m) to (inc)
            var lebar_inc = lebar * 39.37;
            document.getElementById('lebar_inc').value = Math.round(lebar_inc * 100)/100;

            //	Perhitungan Konsumsi Kg/Dz = (Panjang + toleransi) x (Lebar + toleransi) x (Gramasi / 1000) / Skala x 12
            var kons_kgdz = (parseFloat(panjang) + parseFloat(tole_panjang)) * (parseFloat(lebar) + parseFloat(tole_lebar)) * (gramasi/1000) / skala * 12;
            // console.log('kons_kgdz = ' + kons_kgdz);
            document.getElementById('kons_kgdz').value = Math.round(kons_kgdz * 100)/100;

            //	Perhitungan Konsumsi Yard/Dz = (Panjang + toleransi)  / 0.914 / Skala x 12
            var kons_yddz = (parseFloat(panjang) + parseFloat(tole_panjang)) / 0.914 / skala * 12;
            // console.log('kons_yddz = ' + kons_yddz);
            document.getElementById('kons_yddz').value = Math.round(kons_yddz * 100)/100;

            //	Perhitungan Konsumsi Meter/Dz = (Panjang + toleransi) / Skala x 12
            var kons_mdz = (parseFloat(panjang) + parseFloat(tole_panjang)) / skala * 12;
            // console.log('kons_mdz = ' + kons_mdz);
            document.getElementById('kons_mdz').value = Math.round(kons_mdz * 100)/100;

            // Perhitungan Qty per Yard, Kg dan meter = Jumlah Ampar x Total Skala x Konsumsi / 12
            var qty_yard = jml_ampar * skala * kons_yddz / 12;
            var qty_kg = jml_ampar * skala * kons_kgdz / 12;
            var qty_m = jml_ampar * skala * kons_mdz / 12;

            document.getElementById('qty_yard').value = Math.round(qty_yard * 100)/100;
            document.getElementById('qty_kg').value = Math.round(qty_kg * 100)/100;
            document.getElementById('qty_m').value = Math.round(qty_m * 100)/100;
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
