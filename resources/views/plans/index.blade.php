@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Plans</h2>
            <div>
                <a href="{{ route('plans.create') }}" class="btn btn-primary">
                    <i class="btn-icon-prepend" data-feather="plus"></i> Add New
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table" id="dataTableExample">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service plan</th>
                                        <th>DL rate (kbps)</th>
                                        <th>UL rate (kbps)</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->srvname }}</td>
                                            <td>{{ $data->downrate }}</td>
                                            <td>{{ $data->uprate }}</td>
                                            <td class="text-end">
                                                {{-- <a href="{{ route('plan.edit', $data->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('plan.destroy', $data->id) }}"
                                                    method="POST" style="display:inline-block"
                                                    onsubmit="return confirm('Delete this identity?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No identities found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <table class="table" id="dataTableExample">
                                <tbody>
                                    <tr class="tb-header" bgcolor="#dddddd">
                                        <th width="20" height="20" nowrap="" align="center">
                                            <font color="#000000">#</font>
                                        </th>
                                        <th width="20" height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="select" type="checkbox" id="select"
                                                    onclick="ToggleCheckBoxes()" <="" th="">
                                            </font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Service plan</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Gross price<br>(ZAR)</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">DL rate<br>(kbps)</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">UL rate<br>(kbps)</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Cisco DL<br>policy map </font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Cisco UL<br>policy map </font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">IP pool</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Download<br>limit</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Upload<br>limit</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Total<br>limit</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Expiry<br>limit</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Online time<br>limit</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Next disabled<br>service</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Next expired<br>service</font>
                                        </th>
                                        <th height="20" nowrap="" align="center">
                                            <font color="#000000">Next daily<br>service</font>
                                        </th>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">1.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="33"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">20MBPS</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000">0.000000</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">20480</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">20480</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#F0F0F0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">2.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="1"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Access
                                                    list - Mikrotik1</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">no limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">no limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">3.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="12"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Access list -
                                                    StarOS</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">no limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">no limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#F0F0F0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">4.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="28"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Cable
                                                    postpaid 1024/768</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000">15.000000</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">1024</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">768</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">5.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="29"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Cable
                                                    prepaid 512/256</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000">10.000000</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">512</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">256</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">
                                                <img src="{{ asset('images/icon-checked.gif') }}">
                                            </font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#F0F0F0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">6.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="2"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Card
                                                    download limit 128 k</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><img src="{{ asset('images/icon-checked.gif') }}"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">7.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="20"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Card
                                                    expiration + download limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">512</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><img src="{{ asset('images/icon-checked.gif') }}"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><img src="{{ asset('images/icon-checked.gif') }}"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#F0F0F0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">8.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="23"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Card
                                                    expiration limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">512</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><img src="{{ asset('images/icon-checked.gif') }}"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">9.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="22"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Card
                                                    online time limit</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">512</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><img src="{{ asset('images/icon-checked.gif') }}"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#F0F0F0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">10.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="0"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Default service</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000">1.190000</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">8192</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">4096</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                    <tr class="normal" bgcolor="#E0E0E0">
                                        <td height="20" bgcolor="#00E51B" nowrap="" align="center">
                                            <font color="#000000">11.</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"><input name="list[]" type="checkbox" id="list[]"
                                                    value="31"></font>
                                        </td>
                                        <td height="20" nowrap="" align="left">
                                            <font color="#000000">Disabled</font>
                                        </td>
                                        <td height="20" nowrap="" align="right">
                                            <font color="#000000">0.000000</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">256</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000">128</font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                        <td height="20" nowrap="" align="center">
                                            <font color="#000000"></font>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
