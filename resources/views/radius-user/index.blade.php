@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Hotspot Users</h2>
            <div>
                <a href="{{ route('radius.users.create') }}" class="btn btn-primary">Create Hotspot User</a>

                <a href="{{ route('radius.users.exportExcel', request()->only(['from_date', 'to_date'])) }}"
                    class="btn btn-primary">
                    <i class="btn-icon-prepend" data-feather="download"></i> Export to Excel
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">                        
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('radius.users.index') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="from_date" class="form-label">From Date</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control"
                                        value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="to_date" class="form-label">To Date</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control"
                                        value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-success">Filter</button>
                                    <a href="{{ route('radius.users.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                        <th>Identity</th>
                                        <th>Username</th>
                                        <th>OTP</th>
                                        <th>MAC Address</th>
                                        <th>Last Logoff</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->identity->name ?? 'Admin' }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->otp ?? 'N/A' }}</td>
                                            <td>{{ $user->mac ?? '' }}</td>
                                            <td>{{ viewDateTime($user->lastlogoff) }}</td>
                                            <td>{{ viewDate($user->createdon) }}</td>
                                            <td>
                                                @if($user->enableuser === '1')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-xs btn-inverse-info viewLogsBtn" data-username="{{ $user->username }}">
                                                    View Logs
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- User Log History Modal -->
                            <div class="modal fade" id="userLogModal" tabindex="-1" aria-labelledby="userLogModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="userLogModalLabel">User Log History</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="userLogsContent" class="table-responsive text-center">
                                            <p class="text-muted">Loading logs...</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('.viewLogsBtn').click(function() {
        // let userId = $(this).data('user-id');
        let username = $(this).data('username');
        // alert(username)
        $('#userLogModalLabel').text('User Log History - ' + username);
        $('#userLogsContent').html('<p class="text-muted">Loading logs...</p>');
        $('#userLogModal').modal('show');

        $.ajax({
            url: "{{ route('radius.users.logs') }}",
            type: 'GET',
            data: { username: username },
            success: function(response) {
                console.log('User Log Response:', response); // ✅ log response in console
                $('#userLogsContent').html(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error); // ✅ log error message
                console.log('Response Text:', xhr.responseText); // ✅ full error output
                $('#userLogsContent').html('<p class="text-danger">Failed to load logs.</p>');
            }
        });
    });
});
</script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
