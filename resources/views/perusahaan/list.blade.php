
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input"><center>{{ $q->kd_perusahaan }}</center></td>
                            <td class="td-input">{{ $q->nama_perusahaan }}</td>
                            <td class="td-input">{{ $q->alamat }}</td>
                            <td class="td-input">{{ $q->phone }}</td>
                            <td class="td-input">
                                <center><img src="{{ url($q->logo) }}" height="50" align="middle"></center>
                            </td>
                            <td>
                                <center>
                                    <a href="/perusahaan/delete/{{ $q->kd_perusahaan }}" onclick="return confirm('Hapus Perusahaan {{ $q->nama_perusahaan }}, Lanjutkan?');" class="btn btn-danger btn-xs tooltips" data-popup="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-x"></i></a> &nbsp
                                    <a href="#" data-toggle="modal" data-target="#modal_edit{{ $q->kd_perusahaan }}"class="btn btn-primary btn-xs tooltips" data-popup="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-pencil"></i></a>
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr> 

