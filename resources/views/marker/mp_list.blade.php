{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$q->id}}">
    <td class="td-input"><a href="/mp/detail/{{$q->id}}">{{$q->number}}</a></td>
    <td class="td-input">{{ $q->style }}</td>
    <td class="td-input">{{ $q->order_name }}</td>
    <td class="td-input">
        <center>
            <a href="/mcp/delete/{{$q->id}}"
                onclick="return confirm('Hapus Prouction Marker Dengan Nomor {{ $q->number }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="/mcp/edit/{{$q->id}}" class="btn btn-primary btn-xs tooltips" data-id="{{$q->id}}"
                data-popup="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important;">
    <td colspan="8">
        <center>{{ $result->links() }}</center>
    </td>
</tr>
