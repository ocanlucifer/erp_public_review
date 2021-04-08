
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input">
                                <center>
                                @if ($q->email_verified_at != '')
                                    <i class="icon-checkmark-circle2 btn-success" title="Verified"></i>
                                @else
                                    <i class="icon-checkmark-circle2 btn-danger" title="Not Verified"></i>
                                @endif
                                </center>
                            </td>
                            <td class="td-input">{{ $q->email }}</td>
                            <td class="td-input">{{ $q->name }}</td>
                            <td class="td-input"><center>{{ $q->user_perusahaan['nama_perusahaan'] }}</center></td>
                            <td class="td-input"><center>{{ $q->user_divisi['nama_divisi'] }}</center></td>
                            <td class="td-input"><center>{{ $q->hak_akses }}</center></td>
                            <td  style="min-width:70 !important">
                                <center>
                                    <a href="/manage_user/reset_password/{{$q->id}}" onclick="return confirm('Reset Password Lanjutkan?');" class="btn btn-warning btn-xs" title="Reset Password"><i class="icon-reset"></i></a> &nbsp

                                    <a href="" data-toggle="modal" data-target="#modal_edit{{ $q->id }}" class="btn btn-primary btn-xs" title="Edit"><i class="icon-pencil"></i></a> &nbsp

                                    <a href="/manage_user/delete/{{$q->id}}" onclick="return confirm('Hapus User, Lanjutkan?');" class="btn btn-danger btn-xs" title="Delete"><i class="icon-x"></i></a> &nbsp
                                </center>
                            </td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr> 

