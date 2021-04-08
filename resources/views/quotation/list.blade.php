
                          {{ csrf_field() }}
                        <?php $no = 0; ?>
                        @foreach($result as $q)
                        <?php $no++; ?>
                        <tr  style="font-size: 12px !important;">
                            <td class="td-input"><center><a href="/quotation/view/{{ $q->code }}">{{ $q->code }}</a></center></td>
                            <td class="td-input">{{ $q->cust }}</td>
                            <td class="td-input">{{ $q->brand }}</td>
                            <td class="td-input">{{ $q->season }}</td>
                            <td class="td-input">{{ $q->style }}</td>
                            <td class="td-input">{{ $q->bu }}</td>
                            <td class="td-input">{{ $q->user['name'] }}</td>
                            <td class="td-input">{{ $q->user_update['name'] }}</td>
                        </tr>
                        @endforeach
                        <tr  style="font-size: 12px !important;">
                          <td colspan="8"><center>{{ $result->links() }}</center></td>
                        </tr>