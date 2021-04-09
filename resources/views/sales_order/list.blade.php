{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id" value="{{$q->id}}">
    <td class="td-input"> <a href="/so_assortment/{{$q->id}}">
            {{$q->number}}
        </a></td>
    <td class="td-input">{{ $q->code_quotation}}</td>
    <td class="td-input">{{ $q->order_date }}</td>
    <td class="td-input">{{ $q->delivery_date }}</td>
    <td class="td-input">{{ $q->customer }}</td>
    <td class="td-input">{{ $q->style }}</td>
    <td class="td-input">{{ $q->garment_type}}</td>
    <td class="td-input">{{ $q->agent }}</td>
    <td class="td-input">{{ $q->state }}</td>
    <td>
        <center>
            <a href="/salesorders/delete/{{ $q->id }}"
                onclick="return confirm('Hapus order dengan no. {{ $q->number }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="/salesorders/edit/{{$q->id}}" class="btn btn-primary btn-xs tooltips" data-popup="tooltip"
                data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important;">
    <td colspan="8">
        <center>{{ $result->links() }}</center>
    </td>
</tr>
