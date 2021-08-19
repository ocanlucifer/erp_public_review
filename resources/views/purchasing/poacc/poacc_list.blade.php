{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>

<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="">
    <td><input type="checkbox" aria-label="Checkbox for following text input"></td>
    <td class="td-input"><a href="/purchasing/acc_orders/{{$q->id}}">{{$q->number}}</a></td>
    <td class="td-input">{{$q->supplier}}</td>
    <td class="td-input">{{$q->state}}</td>
    <td class="td-input">{{$q->currency}}</td>
    <td class="td-input">{{$q->order_date}}</td>
    <td class="td-input">{{$q->start_date}}</td>
    <td class="td-input">{{$q->end_date}}</td>
    <td class="td-input">{{$q->price_term}}</td>
    <td class="td-input">{{$q->payment_term}}</td>
    <td class="td-input">
        <center>
            <a href="/purchasing/acc_orders/{{$q->id}}/delete"
                onclick="return confirm('hapus {{$q->number}}, lanjutkan?');" class=" btn btn-danger btn-xs tooltips"
                data-popup="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-x"></i></a>&nbsp
            <a href="#modal_edit" data-toggle="modal" onclick="getDetail({{$q->id}})"
                class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
        </center>
    </td>
    @endforeach
