
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input"><center><a href="/material/edit/{{ $q->code }}">{{ $q->code }}</a></center></td>
                            <td class="td-input">{{ $q->tipe }}</td>
                            <td class="td-input">{{ $q->deskripsi }}</td>
                            <td class="td-input">{{ $q->remarks }}</td>
                            <td class="td-input">{{ $q->user_create['name'] }}</td>
                            <td class="td-input">{{ $q->created_at }}</td>
                            <td class="td-input">{{ $q->user_update['name'] }}</td>
                            <td class="td-input">{{ $q->updated_at }}</td>
                            <td>
                                <center>
                                    <a href="/material/delete/{{ $q->code }}" onclick="return confirm('Hapus Material {{ $q->deskripsi }}, Lanjutkan?');" class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-x"></i></a>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="11"><center>{{ $result->links() }}</center></td>
                        </tr> 

