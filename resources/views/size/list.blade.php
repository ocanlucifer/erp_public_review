
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input"><center>{{ $q->name }}</center></td>
                            <td class="td-input"><center>{{ $q->weight }}</center></td>
                            <td class="td-input"><center>{{ $q->status }}</center></td>
                            <td>
                                <center>
                                    <a href="/size/delete/{{ $q->name }}" onclick="return confirm('Hapus Size {{ $q->name }}, Lanjutkan?');" class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-x"></i></a> &nbsp
                                    <a href="#" data-toggle="modal" data-target="#modal_edit" onclick="ModalEdit('{{$q->name}}');" class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr> 

