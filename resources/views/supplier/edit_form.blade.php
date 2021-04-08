
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class=""> 
 
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/supplier') }}">Supplier</a></li>
      <li class="breadcrumb-item active">Edit Data Supplier</li>
  </ol>

        <div class="card">
            <div class="card-header">
                Data Supplier
            </div>
            <div class="card-body">
              <form method="post" action="/supplier/update"  enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="container">
                <div class="form-row">
                  <div class="col-md-5">
                    <div class="row">
                      <label>Supplier Code<span style="color: red"> *</span></label>
                      <input type="text" name="code" value="{{ $supplier->code }}" class="form-control @error('code') is-invalid @enderror" autocomplete="off" readonly>
                      @error('code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Nama Supplier<span style="color: red"> *</span></label>
                      <input type="text" name="nama" value="{{ $supplier->nama }}" class="form-control @error('nama') is-invalid @enderror" autocomplete="off" autofocus>
                      @error('nama')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Alamat Supplier<span style="color: red"> *</span></label>
                      <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" autocomplete="off" rows="3">{{ $supplier->alamat }}</textarea>
                      @error('alamat')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Phone<span style="color: red"> *</span></label>
                      <input type="number" name="phone" value="{{ $supplier->phone }}" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">
                      @error('phone')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>TOP<span style="color: red"> *</span></label>
                      <input type="number" name="top" value="{{ $supplier->top }}" class="form-control @error('top') is-invalid @enderror" autocomplete="off">
                      @error('top')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>PPN<span style="color: red"> *</span></label>
                      <select name="ppn" class="form-control @error('ppn') is-invalid @enderror">
                        <option selected value="{{ $supplier->ppn }}">{{ $supplier->ppn }}%</option>
                        @foreach($ppn as $q)
                          <option value="{{ $q->ppn }}">{{ $q->ppn }}</option>
                        @endforeach
                      </select>
                      <!-- <input type="number" name="ppn" value="{{ old('ppn') }}" class="form-control @error('ppn') is-invalid @enderror" autocomplete="off"> -->
                      @error('ppn')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Contact Person<span style="color: red"> *</span></label>
                      <input type="text" name="contact_name" value="{{ $supplier->contact_name }}" class="form-control @error('contact_name') is-invalid @enderror" autocomplete="off">
                      @error('contact_name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Country</label>
                      <input type="hidden" name="country_code" id="country_code" value="{{ $supplier->country_code }}" class="form-control @error('country_code') is-invalid @enderror" autocomplete="off">
                      <input type="text" name="country" id="country" value="{{ $supplier->country['name'] }}" class="form-control @error('country_code') is-invalid @enderror" autocomplete="off">
                      <span><div id="countrylist"></div></span>
                      @error('country_code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Supplier Email</label>
                      <input type="email" name="email" value="{{ $supplier->email }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off">
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-5">
                    <div class="row">
                      <label>NPWP</label>
                      <input type="text" name="npwp" value="{{ $supplier->npwp }}" class="form-control @error('npwp') is-invalid @enderror" autocomplete="off">
                      @error('npwp')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Bank</label>
                      <input type="text" name="bank" value="{{ $supplier->bank }}" class="form-control @error('bank') is-invalid @enderror" autocomplete="off">
                      @error('bank')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Rekening</label>
                      <input type="number" name="rekening" value="{{ $supplier->rekening }}" class="form-control @error('rekening') is-invalid @enderror" autocomplete="off">
                      @error('rekening')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Currency<span style="color: red"> *</span></label>
                      <input type="hidden" name="currency" id="currency" value="{{ $supplier->currency }}" class="form-control @error('currency') is-invalid @enderror" autocomplete="off">
                      <input type="text" name="currency_name" id="currency_name" value="{{ $supplier->currencies['nama'] }}" class="form-control @error('currency') is-invalid @enderror" autocomplete="off">
                      <span><div id="currencylist"></div></span>
                      @error('currency')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Exchange Rate</label>
                      <input type="number" name="exchange_rate" value="{{ $supplier->exchange_rate }}" class="form-control @error('exchange_rate') is-invalid @enderror" step="any" autocomplete="off">
                      @error('exchange_rate')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Price Term</label>
                      <input type="text" name="price_term" value="{{ $supplier->price_term }}" class="form-control @error('price_term') is-invalid @enderror" autocomplete="off">
                      @error('price_term')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Payment Term</label>
                      <input type="text" name="payment_term" value="{{ $supplier->payment_term }}" class="form-control @error('payment_term') is-invalid @enderror" autocomplete="off">
                      @error('payment_term')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Remarks</label>
                      <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" autocomplete="off" rows="3">{{ $supplier->remarks }}</textarea>
                      @error('remarks')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-1"></div>

                  <div class="col-md-auto">
                    <div class="row">
                      <input type="hidden" name="updated_by" value="{{ Auth::user()->id }}" required>
                      <label><p align="right">Field dengan<span style="color: red"> *</span> Wajib di isi<p></label>
                    </div>
                    <br>
                    <div class="row">
                        <p align="right">
                          <input type="submit" class="btn btn-success" value="Update Supplier">
                          <a href="/supplier" class="btn btn-info">Cancel</a>
                        </p>
                    </div>
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
    $(document).ready(function(){
        $('#country').keyup(function(){ 
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
                            $('#countrylist').fadeIn();  
                            $('#countrylist').html(data);
                        } else {
                            $('#countrylist').fadeOut();
                            $('#countrylist').empty();
                            $('#country_code').val('');
                            $('#country').val('');
                        }
                    }
                });
            }
        });

        $('#currency_name').keyup(function(){ 
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.currency') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        if (data!='') {
                            $('#currencylist').fadeIn();  
                            $('#currencylist').html(data);
                        } else {
                            $('#currencylist').fadeOut();
                            $('#currencylist').empty();
                            $('#currency_name').val('');
                            $('#currency').val('');
                        }
                    }
                });
            }
        });
    });

    function pilihCountry($ls){
        var ls = $ls;
        var ls = $ls; 
        $('#country_code').val($('#code'+ls).text());  
        $('#country').val($('#name'+ls).text());  
        $('#countrylist').fadeOut();
    }
    
    function pilihCurrency($ls){
        var ls = $ls;
        var ls = $ls; 
        $('#currency').val($('#code'+ls).text());  
        $('#currency_name').val($('#nama'+ls).text());  
        $('#currencylist').fadeOut();
    }

</script>