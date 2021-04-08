{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$q->id}}">
    <td>
        <center>{{$no}}</center>
    </td>
    <td class="td-input"><a href="{{url('/markerfabric').'/' . $q->id}}">{{ $q->nama_marker }}</a></td>
    <td class="td-input">{{ $q->style }}</td>
    <td>
        <center>
            <a href="/marker/delete/{{ $q->id }}"
                onclick="return confirm('Hapus Marker {{ $q->nama_marker }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="#" data-toggle="modal" data-target="#modal_edit{{ $q->id }}"
                class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit"
                data-placement="top"><i class="icon-pencil"></i></a>
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important;">
    <td colspan="8">
        <center>{{ $result->links() }}</center>
    </td>
</tr>
