
                        
    <div class="container">
    <!--<div class=""> -->
        <div class="card">
            <div class="card-header">
                Data Consumption
            </div>
 <!--<input type="button" name="add_btn" value="Add" id="add_btn"> -->
            <div class="card-body">
                <table class="table table-bordered table-striped table-hove">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buyer</th>
                            <th>Style</th>
                            <th>Size</th>
                            <th>#</th>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="text" class="form-control" placeholder="Order Name" id="order_name"></td>
                            <td><input type="text" class="form-control" placeholder="Style" id="model_name"></td>
                            <td><input type="text" class="form-control" placeholder="Size Name" id="size_name"></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="view">
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($data as $d)
                        <?php $no++; ?>
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $d->order_name }}</td>
                            <td>{{ $d->model_name }}</td>
                            <td>{{ $d->size_name }}</td>
                            <td>
                              <a href="/consumption_staging/load_data/{{ $d->calc_id }}/{{ $d->order_name }}/{{ $d->size_name }}" class="btn btn-info"><i class="icon-search4"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>