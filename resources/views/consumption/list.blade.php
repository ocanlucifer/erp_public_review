{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$q->id}}">
    <td class="td-input"><a href="/consumption/view/{{$q->id}}">{{$q->code}}</a></td>
    <td class="td-input">{{ $q->salesorder->number }}</td>
    <td class="td-input">{{ $q->customer }}</td>
    <td class="td-input">{{ $q->customer_style }}</td>
    <td class="td-input">{{ $q->delivery_date }}</td>
    <td class="td-input">{{ $q->code_quotation }}</td>
    <td class="td-input">{{ $q->status }}</td>
    <td class="td-input">
        <center>
            <a href="/consumption/delete/{{ $q->id }}"
                onclick="return confirm('Hapus Consumption Dengan Code {{ $q->code }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="/consumption/edit/{{$q->id}}" class="btn btn-primary btn-xs tooltips" data-popup="tooltip"
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
