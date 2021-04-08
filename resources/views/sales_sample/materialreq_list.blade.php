{{ csrf_field() }}

<?php $no = 1; ?>
@foreach($result as $q)
<?php $no; ?>
<tr style="font-size: 12px !important;" id="row_detail" data-id="{{$q->id}}" data-number="{{$q->number}}" data-idsales="{{$q->id_sales_sample}}"
    data-name="{{$no}}">
    <input type="hidden" id="id_requirements" name="id" value="{{$q->id}}">
    <td class="td-input">{{$no++}}</td>
    <td class="td-input">{{ $q->number}}</td>
    <td class="td-input">{{ $q->fabricconst['name']}}</td>
    <td class="td-input">{{ $q->fabriccomp['name'] }}</td>
    <td class="td-input">{{ $q->fabric_description }}</td>
    <td class="td-input">{{ $q->budget }}</td>
    <td class="td-input">{{ $q->po_status }}</td>
    <td class="td-input">{{ $q->state}}</td>
    <td class="td-input">{{ $q->user['name'] }}</td>
    <td class="td-input">{{ $q->note }}</td>
    <td>
        <?php $id_sales_sample = Request::segment(3); ?>
        <center>
            <a href="/salessamples/materialrequirements/delete/{{ $q->id }}/{{$id_sales_sample}}"
                onclick="return confirm('Hapus material requirement, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="/salessamples/materialrequirements/edit/{{ $q->id }}/{{$id_sales_sample}}"
                class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit"
                data-placement="top"><i class="icon-pencil"></i></a> &nbsp
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important;">
    <td colspan="8">
        <center>{{ $result->links() }}</center>
    </td>
</tr>
