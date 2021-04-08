<?php
$res = count($result);
if ($res > 0) :
?>

{{ csrf_field() }}

<?php
$no = 0;
$quantity_total = 0;
$consumption_total = 0;
$efficiency_total = 0;
$qty_unit_total = 0;
$act_unit_total = 0;
?>
@foreach($result as $res)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="{{$res->id}}">
    <td>
        <center>{{$no}}</center>
    </td>
    <td class="td-input">{{ $res->width }}</td>
    <td class="td-input">{{ $res->quantity }}</td>
    <td class="td-input">{{ $res->consumption }}</td>
    <td class="td-input">{{ $res->efficiency }}</td>
    <td class="td-input">{{ $res->qty_unit }}</td>
    <td class="td-input">{{ $res->act_unit}}</td>

    <?php
    $quantity_total += $res['quantity'];
    $consumption_total += $res['consumption'];
    $efficiency_total += $res['efficiency'];
    $qty_unit_total += $res['qty_unit'];
    $act_unit_total += $res['act_unit'];
    ?>

    <td>
        <center>
            <a href="/markerdesc/delete/{{ $res->id }}"
                onclick="return confirm('Hapus Marker {{ $res->id }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a> &nbsp
            <a href="#" id="btn_edit" data-toggle="modal" data-target="#modal_edit{{$res->id}}"
                class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit"
                data-placement="top"><i class="icon-pencil"></i></a>
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important; font-weight: bold">
    <td colspan="2"></td>
    <td><?=$quantity_total; ?></td>
    <td><?=$consumption_total/$no; ?></td>
    <td><?=$efficiency_total/$no; ?></td>
    <td><?=$qty_unit_total; ?></td>
    <td><?=$act_unit_total; ?></td>
    <td></td>
</tr>

{{-- <tr style="font-size: 12px !important;">
    <td colspan="8">
        <center>{{ $result->links() }}</center>
</td>
</tr> --}}

<?php endif; ?>
