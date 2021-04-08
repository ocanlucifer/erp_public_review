
@extends('layouts.app')

@section('content')


<!-- <div class="container"> -->
<div class=""> 
 
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Customer</a></li>
      <li class="breadcrumb-item active">Edit Data Customer</li>
  </ol>

        <div class="card">
            <div class="card-header">
                Data Customer
            </div>
            <div class="card-body">
              <form method="post" action="/customer/update"  enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="container">
                <div class="form-row">
                  <div class="col-md-5">
                    <div class="row">
                      <label>Customer Code<span style="color: red"> *</span></label>
                      <input type="text" name="code" value="{{ $customer->code }}" class="form-control @error('code') is-invalid @enderror" autocomplete="off" readonly>
                      @error('code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Nama Customer<span style="color: red"> *</span></label>
                      <input type="text" name="nama" value="{{ $customer->nama }}" class="form-control @error('nama') is-invalid @enderror" autocomplete="off" autofocus>
                      @error('nama')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Alamat Customer<span style="color: red"> *</span></label>
                      <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" autocomplete="off" rows="3">{{ $customer->alamat }}</textarea>
                      @error('alamat')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Phone<span style="color: red"> *</span></label>
                      <input type="number" name="phone" value="{{ $customer->phone }}" class="form-control @error('phone') is-invalid @enderror" autocomplete="off">
                      @error('phone')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>TOP<span style="color: red"> *</span></label>
                      <input type="number" name="top" value="{{ $customer->top }}" class="form-control @error('top') is-invalid @enderror" autocomplete="off">
                      @error('top')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Contact Person<span style="color: red"> *</span></label>
                      <input type="text" name="contact_name" value="{{ $customer->contact_name }}" class="form-control @error('contact_name') is-invalid @enderror" autocomplete="off">
                      @error('contact_name')
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
                      <label>Country<span style="color: red"> *</span></label>
                      <input type="hidden" name="country_code" id="country_code" value="{{ $customer->country_code }}" class="form-control @error('country_code') is-invalid @enderror" autocomplete="off">
                      <input type="text" name="country" id="country" value="{{ $customer->country['name'] }}" class="form-control @error('country_code') is-invalid @enderror" autocomplete="off">
                      <span><div id="countrylist"></div></span>
                      @error('country_code')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Customer Email</label>
                      <input type="email" name="email" value="{{ $customer->email }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off">
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>NPWP</label>
                      <input type="text" name="npwp" value="{{ $customer->npwp }}" class="form-control @error('npwp') is-invalid @enderror" autocomplete="off">
                      @error('npwp')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Bank</label>
                      <input type="text" name="bank" value="{{ $customer->bank }}" class="form-control @error('bank') is-invalid @enderror" autocomplete="off">
                      @error('bank')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Rekening</label>
                      <input type="number" name="rekening" value="{{ $customer->rekening }}" class="form-control @error('rekening') is-invalid @enderror" autocomplete="off">
                      @error('rekening')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <br>
                    <div class="row">
                      <label>Remarks</label>
                      <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" autocomplete="off" rows="3">{{ $customer->remarks }}</textarea>
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
                          <input type="submit" class="btn btn-success" value="Update Customer">
                          <a href="/customer" class="btn btn-info">Cancel</a>
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
    });

    function pilihCountry($ls){
        var ls = $ls;
        var ls = $ls; 
        $('#country_code').val($('#code'+ls).text());  
        $('#country').val($('#name'+ls).text());  
        $('#countrylist').fadeOut();
    }

</script>