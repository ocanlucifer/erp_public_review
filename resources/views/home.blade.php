@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($error = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <?php echo $error; ?>
                    </div>
                    @endif
                    <div class="col-md-auto">
                    <div class="col-md-3">
                        <a href="/po">
                            <div class="card">
                                <div class="card-header"><center>Purchase Order</center></div>
                                <div class="card-body icon-3x icon-cart-remove"></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <a href="/cash_request">
                            <div class="card">
                                <div class="card-header"><center>Cash Request</center></div>
                                <div class="card-body icon-3x icon-cash"></div>
                            </div>
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
