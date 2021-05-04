<?php

foreach ($mcpt as $type) {
    if ($type['type'] == 'MARKER') {
        // MARKER

    } elseif ($type['type'] == 'PIPING') {
        // PIPING
    }
}
?>

<tr class="font-weight-bold">
    <td></td>
    <td>Jenis Kain</td>
    <td>Warna</td>
    <td>Komponen</td>
    <td>Type</td>
    <td>Destination</td>
    <td colspan="2" class="text-center">Action</td>
</tr>
<tr>
    <td></td>
    <td>{{$mcpt->no_urut}}. {{$mcpt->fabricconst}}</td>
    <td>{{$mcpt->warna}}</td>
    <td>{{$mcpt->component}}</td>
    <td>{{$mcpt->type}}</td>
    <td>{{$mcpt->tujuan}}</td>
    <td colspan="2" class="text-center">
        <div class="dropdown">
            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
            <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                {{-- <a class="dropdown-item" href="#">Print Rekap Hitung</a> --}}

                @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                <a class="dropdown-item" href="/mcp/edit_mcpt/{{$mcpt->id}}/{{$mcp->id}}">Edit</a>
                <a class="dropdown-item click_newdetail" href="#" data-toggle="modal" data-target="#form-detail" data-detype="{{$mcpt->id}}" data-deqty="{{$qty_for_detail}}" data-desize="{{$size_for_detail}}" id="click_newdetail" onclick="newDetail()">New Detail
                </a>
                <hr>
                <a class="dropdown-item" href="#">Destroy</a>
                @endif

            </div>
        </div>
    </td>
</tr>
<?php foreach ($mcp_detail as $mcpd) { ?>
    <?php if ($mcpd['id_type'] == $mcpt['id']) { ?>
        <tr>
            <td colspan="2"></td>
            <td><b>Marker ke</b></td>
            <td><b>Code</b></td>
            <td><b>Panjang</b></td>
            <td><b>Lebar</b></td>
            <td><b>Gramasi</b></td>
            <td><b>Action</b></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td><a href="/mcp/show_detail/{{$mcpd->id}}/{{$mcp->id}}/{{$qty_for_detail}}/{{$size_for_detail}}" id="click_showdetail">M
                    {{$mcpd->urutan}}</a>
            </td>
            <td>{{$mcpd->code}}</td>
            <td>{{$mcpd->panjang_m}}</td>
            <td>{{$mcpd->lebar_m}}(m),{{number_format((float)($mcpd->lebar_m * 39.37), 2, '.', '')}}(inc)
            </td>
            <td>{{$mcpd->gramasi}}</td>
            <td class="text-center">
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu text" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Print Detail</a>

                        @if ($mcp->state == "UNCONFIRMED" || $mcp->state == "PENDING")
                        <a class="dropdown-item" href="/mcp/edit_mcpd/{{$mcpd->id}}/{{$mcp->id}}/{{$qty_for_detail}}/{{$size_for_detail}}">Edit</a>
                        <hr>
                        <a class="dropdown-item" href="#">Destroy</a>
                        @endif

                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td colspan="2" class="text-center">
                <a href="/mcp/print_ws/{{$mcp->id}}/{{$mcpwsm_print}}/{{$mcpt->id}}/{{$mcpd->id}}" target="_blank" class="btn btn-primary">Print Rekap Hitung</a>
            </td>
            {{-- <td colspan="2" class="text-center"><a
                                    href="{{ route('mcp.print_ws', ['mcp_id' => $mcp->id, '$mcpwsm_id' => $mcpwsm_print, 'mcpt_id' => $mcpt->id, 'mcpd_id' => $mcpd->id]) }}"
            target="_blank" class="btn btn-primary">Print Document</a></td> --}}
        </tr>
    <?php } ?>
<?php } ?>
