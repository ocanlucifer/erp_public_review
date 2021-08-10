{{ csrf_field() }}

<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>

<tr style="font-size: 12px !important;">
    <input type="hidden" name="id_marker" value="">
    <td class="td-input"><a href="/mcd/{{$q->id}}">{{$q->mc_number}}</a></td>
    <td class="td-input">{{$q->order}}</td>
    <td class="td-input">{{$q->style}}</td>
    <td class="td-input">{{$q->combo}}</td>
    <td class="td-input">{{$q->fabricconst}}</td>
    <td class="td-input">{{$q->fabriccomp}}</td>
    <td class="td-input">
        <center>
            <a href="/markercal/delete/{{$q->id}}" onclick="return confirm('hapus {{$q->mc_number}}, lanjutkan?');"
                class=" btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a>&nbsp
            <a href="#modal_edit" data-toggle="modal" onclick="getDetail({{$q->id}})"
                class="btn btn-primary btn-xs tooltips"><i class="icon-pencil"></i></a>
        </center>
    </td>
    @endforeach
