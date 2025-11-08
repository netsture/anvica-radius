@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">User Logs</h3>
            <div>
                <a href="{{ route('radius.users.all.logs.export', request()->only(['from_date', 'to_date'])) }}"
                    class="btn btn-primary">
                    <i class="btn-icon-prepend" data-feather="download"></i> Export to Excel
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table" id="dataTableExample" data-display-length="100" style="font-size: 14px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>MAC</th>
                                        <th>Ipaddress</th>
                                        <th>Login</th>
                                        <th>Logout</th>
                                        <th>Session Time</th>
                                        {{-- <th>Input Octets</th>
                                        <th>Output Octets</th>
                                        <th>NAS IP</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $index => $log)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $log->username }}</td>
                                            <td>{{ $log->callingstationid ?? 'N/A' }}</td>
                                            <td>{{ $log->framedipaddress ?? 'N/A' }}</td>
                                            <td>{{ viewDateTime($log->acctstarttime) ?? '-' }}</td>
                                            <td>{{ viewDateTime($log->acctstoptime) ?? '0' }}</td>
                                            <td>{{ $log->acctsessiontime ?? '0' }}</td>
                                            {{-- <td>{{ number_format($log->acctinputoctets ?? 0) }}</td>
                                            <td>{{ number_format($log->acctoutputoctets ?? 0) }}</td>
                                            <td>{{ $log->nasipaddress ?? '-' }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
