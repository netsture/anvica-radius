@if (empty($logs))
    <p class="text-muted">No logs found for this user.</p>
@else
    <div class="d-flex justify-content-between mb-2">
        <h5>User Logs</h5>
        <a href="{{ route('radius.users.logs.export', ['username' => $username]) }}" 
           class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export to Excel
        </a>
    </div>

    <table class="table table-bordered table-sm" style="font-size: 14px;">
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
@endif
