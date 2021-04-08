
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input">{{ $q->no_pengajuan }}</td>
                            <td class="td-input"><center><a href="#" onclick="window.open('/priview_pdf/{{ $q->id }}','name','width=800,height=600'); return false;" target="_top">{{ $q->file }}</a></center></td>
                            <td class="td-input"><center>{{ $q->user_create['name'] }}</center></td>
                            <td class="td-input"><center>{{ $q->created_at }}</center></td>
                            <td class="td-input"><center>{{ $q->user_create['divisi'] }}</center></td>
                            <td class="td-input"><center>{{ $q->user_checked['name'] }}</center></td>
                            <td class="td-input"><center>{{ $q->tgl_approve_1 }}</center></td>
                            <td class="td-input"><center>{{ $q->user_checked_2['name'] }}</center></td>
                            <td class="td-input"><center>{{ $q->tgl_approve_2 }}</center></td>
                            <td <?php if ($q->status_2 == 'approved') { echo 'class="td-input bg-success"'; } elseif ($q->status_2 == 'rejected') {echo 'class="td-input bg-danger"';} else { echo 'class="td-input bg-warning"'; } ?> ><center>{{ $q->status_2 }} : {{$q->keterangan_reject_2}}</center></td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr> 

