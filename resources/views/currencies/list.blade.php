
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input"><center>{{ $q->code }}</center></td>
                            <td class="td-input">{{ $q->nama }}</td>
                            <td class="td-input">{{ $q->sign }}</td>
                            <td>
                                <center>
                                    <a href="/perusahaan/delete/{{ $q->code }}" onclick="return confirm('Hapus Currencies {{ $q->nama }}, Lanjutkan?');" class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-x"></i></a> &nbsp
                                    <a href="#" data-toggle="modal" data-target="#modal_edit{{ $q->code }}"class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr> 

