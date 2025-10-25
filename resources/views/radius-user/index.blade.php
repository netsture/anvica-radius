@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="main-content d-flex justify-content-between flex-wrap">
        <h3 class="page-title">Hotspot Users</h3>
        <div>            
            <a href="{{ route('radius.users.create') }}" class="btn btn-primary">Create Hotspot User</a>

            <a href="{{ route('radius.users.exportExcel') }}" class="btn btn-primary">
                <i class="btn-icon-prepend" data-feather="download"></i> Export to Excel
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
                                    <th>Identity</th>
                                    <th>Username</th>
                                    <th>OTP</th>
                                    <th>MAC Address</th>
                                    <th>Last Logoff</th>
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->identity->name ?? '' }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->otp ?? "N/A" }}</td>
                                    <td>{{ $user->mac ?? "" }}</td>
                                    <td>{{ viewDateTime($user->lastlogoff) }}</td>
                                    <td>{{ viewDate($user->createdon) }}</td>
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
