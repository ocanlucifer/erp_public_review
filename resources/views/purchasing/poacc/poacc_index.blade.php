@extends('layouts.app')

@section('content')
<div class="">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">PO Aksesoris</li>
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
            PO Aksesoris
        </div>
        <div class="card-body">
            <div align="right" class="mb-1">
                <a href="#" onclick="filter_data('unconfirmed')"
                    class="btn btn-sm btn-danger float-left">unconfirmed</a>
                <a href="#" onclick="filter_data('pending')" class="btn btn-sm btn-warning float-left">pending</a>
                <a href="#" onclick="filter_data('reviewed')" class="btn btn-sm btn-info float-left">reviewed</a>
                <a href="#" onclick="filter_data('confirmed')" class="btn btn-sm btn-success float-left">confirmed</a>

                <a href="#" data-toggle="modal" data-target="#modal_new" class="btn btn-primary"><i
                        class="icon-pencil"></i>New Data</a>
            </div>

            <div class="table table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="card-header">
                            <th></th>
                            <th>Number</th>
                            <th>Supplier</th>
                            <th>State</th>
                            <th>Currency</th>
                            <th>Order Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Price Term</th>
                            <th>Payment Term</th>
                            <th>
                                <center>Action</center>
                            </th>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2">
                                <input type="text" class="form-control" onkeyup="getDatas()" name="keyword" id="keyword"
                                    placeholder="Search Number/Supplier/State" autocomplete="off">
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <tbody id="view">
                        @include('purchasing.poacc.poacc_list')
                    </tbody>
                    </thead>
                </table>
            </div>

        </div>
    </div>

    {{-- modal new--}}
    <div class="row">
        <div id="modal_new" class="modal fade">
            <div class="modal-dialog modal-lg" style="margin-left: 5%; margin-right: 5%;">
                <div class="modal-content" id="background-body2" style="width: 150% !important;">
                    <form action="/purchasing/acc_orders/create" method="post" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                        <div class=" modal-header bg-indigo-600">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title"><strong>New PO Accessories</strong></h6>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_number">*Number</label>
                                        <input type="text" name="new_number" id="new_number"
                                            class="form-control bg-warning" value="(auto generate)" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_order_date">*Order Date</label>
                                        <input type="date" name="new_order_date" id="new_order_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_note">Note</label>
                                        <textarea type="text" name="new_note" id="new_note" class="form-control"
                                            cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_numbering">Numbering</label>
                                        <?php $yearnow = date('y'); ?>
                                        <?php $user = strtoupper(Auth::user()->name); ?>
                                        <input type="text" name="new_numbering" id="new_numbering"
                                            class="form-control bg-warning" value="{{$user .'/' . $yearnow}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_start_date">*Start Date</label>
                                        <input type="date" name="new_start_date" id="new_start_date"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_rounding_value">Rounding Value</label>
                                        <input type="number" name="new_rounding_value" id="new_rounding_value"
                                            class="form-control" value="0.00" step="0.01">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_supplier">Supplier</label>
                                        <input type="text" name="new_supplier" id="new_supplier" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_end_date">*End Date</label>
                                        <input type="date" name="new_end_date" id="new_end_date" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_allowance_qty">Allowance Overshipment Quantity</label>
                                        <input type="number" name="new_allowance_qty" id="new_allowance_qty"
                                            class="form-control" value="0.00" step="0.01">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_currency">Currency</label>
                                        <select type="text" name="new_currency" id="new_currency" class="form-control">
                                            <option value="rupiah">Rupiah</option>
                                            <option value="rupiah">Rupiah</option>
                                            <option value="us dollar">US Dollar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_price_term">*Price term</label>
                                        <input type="text" name="new_price_term" id="new_price_term"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_exchange_rate">*Exchange Rate</label>
                                        <input type="number" name="new_exchange_rate" id="new_exchange_rate"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_payment_term">*Payment Term</label>
                                        <input type="text" name="new_payment_term" id="new_payment_term"
                                            class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="new_bank_charges">Bank Charges</label>
                                        <select type="text" name="new_bank_charges" id="new_bank_charges"
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
    </div>

    {{-- modal edit --}}
    <div class="row">
        <div id="modal_edit" class="modal fade">
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
                                            class="form-control bg-warning" value="{{'PO ACCS-' . $yearnow}}" readonly>
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
</div>

</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    function getDatas(page){
        keyword = $('#keyword').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url : '{{URL::to("/purchasing/acc_orders")}}?page=' + page,
            type : 'get',
            dataType: 'json',
            data:{'keyword':keyword ,'_token':_token}
        }).done(function (data) {
            $('tbody').html(data);
            location.hash = page;
        }).fail(function (msg) {
            alert('Gagal menampilkan data, silahkan refresh halaman.');
        });
    }

    function filter_data(state){
        $('#keyword').val(state);
        getDatas();
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
