{{ csrf_field() }}

<?php $no = 0; ?>
<?php $idsalessample = request()->segment(count(request()->segments())); ?>
@foreach($remark_type as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$q->id}}">
    <td>
        <center>{{$no}}</center>
    </td>
    <td class="td-input">{{$q->name}}</td>
    <td>
        <center>
            <a href="/salessamples/remark_type/delete/{{ $q->id }}/{{$idsalessample}}"
                onclick="return confirm('delete remark type {{ $q->name }}, next?');"
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
        <center>{{ $remark_type->links() }}</center>
    </td>
</tr>
