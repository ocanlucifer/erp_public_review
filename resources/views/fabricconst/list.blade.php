{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id" value="{{$q->id}}">
    <td>
        <center>{{$no}}</center>
    </td>
    <td class="td-input">{{ $q->name }}</td>
    <td class="td-input">{{ $q->material_type }}</td>
    <td class="td-input">{{ $q->state }}</td>
    <td>
        <center>
            <a href="/fabric_const/delete/{{ $q->id }}"
                onclick="return confirm('Hapus Marker {{ $q->name }}, Lanjutkan?');"
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
