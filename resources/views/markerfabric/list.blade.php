{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $res)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$res->markerfab_id}}">
    <td>
        <center>{{$no}}</center>
    </td>
    <td class="td-input">{{ $res->marker['nama_marker'] }}</td>
    <td class="td-input">{{ $res->fabricconst['name'] }}</td>
    <td class="td-input">{{ $res->fabriccomp['name']}}</td>
    <td class="td-input"><a href="{{url('/markerdesc').'/' . $res->id}}">{{ $res->description }}</a></td>
    <td class="td-input">{{ $res->gramasi }}</td>
    <td class="td-input">{{ $res->unit }}</td>
    <td class="td-input">{{ $res->marker_type }}</td>
    <td>
        <center>
            <a href="/markerfabric/delete/{{ $res->id }}"
                onclick="return confirm('Hapus Marker {{ $res->description }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="#" id="btn_edit" data-toggle="modal" data-target="#modal_edit{{$res->id}}"
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
