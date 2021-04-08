{{ csrf_field() }}
<?php $no = 0; ?>
@foreach($result as $q)
<?php $no++; ?>
<tr style="font-size: 12px !important;">
    <td class="td-input">
        <center><a href="/customer/edit/{{ $q->code }}">{{ $q->code }}</a></center>
    </td>
    <td class="td-input">{{ $q->nama }}</td>
    <td class="td-input">{{ $q->alamat }}</td>
    <td class="td-input">{{ $q->contact_name }}</td>
    <td class="td-input">{{ $q->country['name'] }}</td>
    <td class="td-input">{{ $q->phone }}</td>
    <td class="td-input">
        <center>{{ $q->top }}</center>
    </td>
    <td class="td-input">{{ $q->email }}</td>
    <td class="td-input">{{ $q->npwp }}</td>
    <td class="td-input">
        <center>{{ $q->bank }}</center>
    </td>
    <td class="td-input">{{ $q->rekening }}</td>
    <td class="td-input">{{ $q->remarks }}</td>
    <td class="td-input">{{ $q->user_create['name'] }}</td>
    <td class="td-input">{{ $q->created_at }}</td>
    <td class="td-input">{{ $q->user_update['name'] }}</td>
    <td class="td-input">{{ $q->updated_at }}</td>
    <td>
        <center>
            <a href="/customer/delete/{{ $q->code }}"
                onclick="return confirm('Hapus Customer {{ $q->nama }}, Lanjutkan?');"
                class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete"
                data-placement="top"><i class="icon-x"></i></a>
        </center>
    </td>
</tr>
@endforeach
<tr style="font-size: 12px !important;">
    <td colspan="15">
        <center>{{ $result->links() }}</center>
    </td>
</tr>
