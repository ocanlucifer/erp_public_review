
@extends('layouts.app')


@section('content')

<!-- <div class="container"> -->
<div class="">
              @foreach($header as $h)
  
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/quotation') }}">Quotation</a></li>
      <li class="breadcrumb-item active">{{$h->code}}</li>
  </ol>
  
        <div class="card">
            <div class="card-header">
                Quotation
            </div>
            <div class="card-body">
              <div class="container">
              <div class="form-row">
                <div class="col-md-3">
                  <div class="row">
                    <label for="cust">Customer</label>
                    <input type="text" readonly id="cust" name="cust" value="{{$h->cust}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="brand">Brand</label>
                    <input type="text" readonly id="brand" name="brand" value="{{$h->brand}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="season">Season</label>
                    <input type="text" id="season" readonly name="season" value="{{$h->season}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="style">Style</label>
                    <input type="text" readonly id="style" name="style" value="{{$h->style}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" readonly cols="16" rows="4">{{$h->description}}</textarea>
                  </div>
                </div>
                
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                  <div class="row">
                    <label for="bu">Business Unit</label>
                    <input type="text" readonly id="bu" name="bu" value="{{$h->bu}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="forecast_qty">Forecast Qty</label>
                    <input type="text" readonly id="forecast_qty" name="forecast_qty" value="{{$h->forecast_qty}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="size_range">Size Range</label>
                    <input type="text" readonly id="size_range" name="size_range" value="{{$h->size_range}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="delivery">Delivery</label>
                    <input type="text" readonly id="delivery" name="delivery" value="{{$h->delivery}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="destination">Destination</label>
                    <input type="text" readonly id="destination" name="destination" value="{{$h->destination}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="tgl_quot">Date Of Quote</label>
                    <input type="text" readonly id="tgl_quot" name="tgl_quot" value="{{$h->tgl_quot}}" class="form-control" required>
                  </div>
                </div>
                
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                  <div class="row">
                    <label for="exchange_rate">Exchange Rate</label>
                    <input type="text" readonly id="exchange_rate" name="exchange_rate" value="{{$h->exchange_rate}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="smv">SMV</label>
                    <input type="text" readonly id="smv" name="smv" value="{{$h->smv}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="rate">Rate</label>
                    <input type="text" readonly id="rate" name="rate" value="{{$h->rate}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="create_by">Created By</label>
                    <input type="text" readonly id="create_by" name="create_by" value="{{$h->user['name']}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="update_by">Update By</label>
                    <input type="text" readonly id="update_by" name="update_by" value="{{$h->user_update['name']}}" class="form-control" required>
                  </div>
                  <div class="row">
                    <label for="update_tgl">Update Date</label>
                    <input type="text" readonly id="update_tgl" name="update_tgl" value="{{$h->update_tgl}}" class="form-control" required>
                  </div>
                </div>
              </div>
            </div>
              <br>
              @endforeach

                <div class="col-md-auto">
                  <div class="row">
                    @foreach($gmbr as $gmbr)
                      <img src="{{ url($gmbr->file) }}" id="gmbr"  height="100" align="middle">&nbsp &nbsp
                    @endforeach
                  </div>
                </div>

              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">FABRIC</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="fabric">
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
                            <td>{{ $no }}</td>
                            <td>{{ $f->position }}</td>
                            <td>{{ $f->jenis_detail }}</td>
                            <td>{{ $f->description }}</td>
                            <td>{{ $f->supplier }}</td>
                            <td>{{ round($f->width,3) }}</td>
                            <td>{{ round($f->cons,3) }}</td>
                            <td>{{ round($f->allowance,3) }}</td>
                            <td>{{ round($allowance_f,3) }}</td>
                            <td>{{ round($f->price,3) }}</td>
                            <td>{{ round($f->freight,3) }}</td>
                            <td>{{ round($freight_f,3) }}</td>
                            <td>{{ round($subtotal_f,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Fabric</b></td>
                        <td>{{ round($total_f,3) }}</td>
                      </tr>
                    </tfoot>
                </table>
              
              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">SPECIAL TRIMS</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="special_trims">
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
                            <td>{{ $no }}</td>
                            <td>{{ $st->position }}</td>
                            <td>{{ $st->jenis_detail }}</td>
                            <td>{{ $st->description }}</td>
                            <td>{{ $st->supplier }}</td>
                            <td>{{ round($st->width,3) }}</td>
                            <td>{{ round($st->cons,3) }}</td>
                            <td>{{ round($st->allowance,3) }}</td>
                            <td>{{ round($allowance_st,3) }}</td>
                            <td>{{ round($st->price,3) }}</td>
                            <td>{{ round($st->freight,3) }}</td>
                            <td>{{ round($freight_st,3) }}</td>
                            <td>{{ round($subtotal_st,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Special Trims</b></td>
                        <td>{{ round($total_st,3) }}</td>
                      </tr>
                    </tfoot>
                </table>

              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">TRIMS</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="trims">
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
                            <td>{{ $no }}</td>
                            <td>{{ $t->position }}</td>
                            <td>{{ $t->jenis_detail }}</td>
                            <td>{{ $t->description }}</td>
                            <td>{{ $t->supplier }}</td>
                            <td>{{ round($t->width,3) }}</td>
                            <td>{{ round($t->cons,3) }}</td>
                            <td>{{ round($t->allowance,3) }}</td>
                            <td>{{ round($allowance_t,3) }}</td>
                            <td>{{ round($t->price,3) }}</td>
                            <td>{{ round($t->freight,3) }}</td>
                            <td>{{ round($freight_t,3) }}</td>
                            <td>{{ round($subtotal_t,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Trims / Accessories</b></td>
                        <td>{{ round($total_t,3) }}</td>
                      </tr>
                    </tfoot>
                </table>

              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">EMBELLISHMENT</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="embellishment">
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
                            <td>{{ $no }}</td>
                            <td>{{ $e->position }}</td>
                            <td>{{ $e->jenis_detail }}</td>
                            <td>{{ $e->description }}</td>
                            <td>{{ $e->supplier }}</td>
                            <td>{{ round($e->width,3) }}</td>
                            <td>{{ round($e->cons,3) }}</td>
                            <td>{{ round($e->allowance,3) }}</td>
                            <td>{{ round($allowance_e,3) }}</td>
                            <td>{{ round($e->price,3) }}</td>
                            <td>{{ round($e->freight,3) }}</td>
                            <td>{{ round($freight_e,3) }}</td>
                            <td>{{ round($subtotal_e,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Embellishment</b></td>
                        <td>{{ round($total_e,3) }}</td>
                      </tr>
                    </tfoot>
                </table>

              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">WASHING</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="washing">
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
                            <td>{{ $no }}</td>
                            <td>{{ $w->position }}</td>
                            <td>{{ $w->jenis_detail }}</td>
                            <td>{{ $w->description }}</td>
                            <td>{{ $w->supplier }}</td>
                            <td>{{ round($w->width,3) }}</td>
                            <td>{{ round($w->cons,3) }}</td>
                            <td>{{ round($w->allowance,3) }}</td>
                            <td>{{ round($allowance_w,3) }}</td>
                            <td>{{ round($w->price,3) }}</td>
                            <td>{{ round($w->freight,3) }}</td>
                            <td>{{ round($freight_w,3) }}</td>
                            <td>{{ round($subtotal_w,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Washing</b></td>
                        <td>{{ round($total_w,3) }}</td>
                      </tr>
                    </tfoot>
                </table>

              <br>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead>
                        <tr bgcolor="#94acf2">
                          <th colspan="13">MISCELLANEOUS</th>
                        </tr>
                        <tr bgcolor="#f2ea94">
                            <th>No</th>
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
                    <tbody id="miscellaneous">
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
                            <td>{{ $no }}</td>
                            <td>{{ $m->position }}</td>
                            <td>{{ $m->jenis_detail }}</td>
                            <td>{{ $m->description }}</td>
                            <td>{{ $m->supplier }}</td>
                            <td>{{ round($m->width,3) }}</td>
                            <td>{{ round($m->cons,3) }}</td>
                            <td>{{ round($m->allowance,3) }}</td>
                            <td>{{ round($allowance_m,3) }}</td>
                            <td>{{ round($m->price,3) }}</td>
                            <td>{{ round($m->freight,3) }}</td>
                            <td>{{ round($freight_m,3) }}</td>
                            <td>{{ round($subtotal_m,3) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr bgcolor="#97ace8">
                        <td colspan="12" align="right"><b>Total Miscelleneous</b></td>
                        <td>{{ round($total_m,3) }}</td>
                      </tr>
                    </tfoot>
                </table>

              <br>
              <div class="form-row">
              <div class="col-md-7">
                <table class="table table-striped table-hover table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
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

                          //rumus budget internal
                          $pengurang_c_m                    = (5/100) * $c_m;
                          $c_m_in                           = $c_m - $pengurang_c_m;

                          $pengurang_total_cost             = (5/100) * $total_cost;
                          $total_cost_in                    = $total_cost - $pengurang_total_cost;

                          // $pengurang_handling               = (5/100) * $handling;
                          // $handling_in                      = $handling - $pengurang_handling;
                          $handling_in                      = $handling;

                          $totcost_handling                 = $total_cost_in + $handling_in; //untuk menjumlah internal cost + handling

                          $margin_in                        = $margin + $pengurang_c_m + $pengurang_total_cost;

                          $peng_total_cost_handling         = (5/100) * $totcost_handling;
                          $total_cost_handling_in           = $totcost_handling - $peng_total_cost_handling;

                          $totcost_handling_margin          = $totcost_handling + $margin_in; //untuk menjumlah internal cost + handling+margin
                          $peng_total_cost_handling_margin  = (5/100) * $totcost_handling_margin;
                          $total_cost_handling_margin_in    = $totcost_handling_margin - $peng_total_cost_handling_margin;

                          // $pengurang_offer_price            = (5/100) * $h->offer_price;
                          // $offer_price_in                   = $h->offer_price - $pengurang_offer_price;
                          $offer_price_in                   = round($total_cost_handling_margin_in);

                          // $pengurang_sales_fee              = (5/100) * $sales_fee;
                          // $sales_fee_in                     = $sales_fee - $pengurang_sales_fee;
                          $sales_fee_in                     = $sales_fee;

                          $tot_offer_sales                  = $offer_price_in + $sales_fee_in; //untuk menjumlah offerprice+salesfee

                          $pengurang_offer_price_sales_fee  = (5/100) * $tot_offer_sales ;
                          $offer_price_sales_fee_in         = $tot_offer_sales  - $pengurang_offer_price_sales_fee;

                          $pengurang_confirm_price            = (5/100) * $h->confirm_price;
                          $confirm_price_in                   = $h->confirm_price - $pengurang_confirm_price;
                        ?>
                        <tr>
                            <td colspan="11">CM (Cut / Make)</td>
                            <td></td>
                            <td>{{ round($c_m,3) }}</td>
                            <td bgcolor="success">{{ round($c_m_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Total Cost</td>
                            <td></td>
                            <td>{{ round($total_cost,3) }}</td>
                            <td bgcolor="success">{{ round($total_cost_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Handling</td>
                            <td bgcolor="#f2ea94">{{$h->handling}}%</td>
                            <td>{{ round($handling,3) }}</td>
                            <td bgcolor="success">{{ round($handling_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Total Cost + Handling</td>
                            <td></td>
                            <td>{{ round($total_cost_handling,3) }}</td>
                            <td bgcolor="success">{{ round($total_cost_handling_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Margin</td>
                            <td bgcolor="#f2ea94">{{$h->margin}}%</td>
                            <td>{{ round($margin,3) }}</td>
                            <td bgcolor="success">{{ round($margin_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Total Cost + Handling + margin</td>
                            <td></td>
                            <td>{{ round($total_cost_handling_margin,3) }}</td>
                            <td bgcolor="success">{{ round($total_cost_handling_margin_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Offer Price</td>
                            <td></td>
                            <td>{{ round($h->offer_price,3) }}</td>
                            <td bgcolor="success">{{ round($offer_price_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Sales Fee</td>
                            <td bgcolor="#f2ea94">{{$h->sales_fee}}%</td>
                            <td>{{ round($sales_fee,3) }}</td>
                            <td bgcolor="success">{{ round($sales_fee_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Offer Price + Sales Fee</td>
                            <td></td>
                            <td>{{ round($offer_price_sales_fee,3) }}</td>
                            <td bgcolor="success">{{ round($offer_price_sales_fee_in,3) }}</td>
                        </tr>
                        <tr>
                            <td colspan="11">Confirmed Price</td>
                            <td></td>
                            <td>{{ round($h->confirm_price,3) }}</td>
                            <td bgcolor="success">{{ round($h->confirm_price_in,3) }}</td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <div class="col-md-1"><br></div>
              <div class="col-md-auto">
                <div class="form-group">
                    <p align="right"><a href="/quotation/edit/{{$h->code}}" class="btn btn-danger"><i class="icon-pencil7"></i> Edit Quotation</a></p>
                </div>
                <div class="form-group">
                    <p align="right"><a href="/quotation/cloning/{{$h->code}}" class="btn btn-success"><i class="icon-copy4"></i> Clone Quotation</a></p>
                </div>
              </div>
                        @endforeach
              </div>
            </div>
        </div>
    </div>


@endsection
