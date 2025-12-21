@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Router Status</h2>
            <div>
                <a href="{{ route('routerstatus.logs') }}" class="btn btn-primary">
                    View Logs
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo "Date: ".date('Y-m-d H:i:s');?></h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table" id="dataTableExample" data-display-length="100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Status</th>
                                        <th>Router</th>
                                        <th>MAC</th>
                                        <th>Model</th>
                                        <th>Serial</th>
                                        <th>IP Address</th>
                                        <th>Last Event Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($log->status === 'UP')
                                                    <span class="badge bg-success">UP</span>
                                                @else
                                                    <span class="badge bg-danger">DOWN</span>
                                                @endif
                                            </td>
                                            <td>{{ $log->router }}</td>
                                            <td>{{ $log->mac }}</td>
                                            <td>{{ $log->model }}</td>
                                            <td>{{ $log->serial }}</td>                                            
                                            <td>{{ $log->ip_address ?? '-' }}</td>
                                            <td>{{ $log->last_event_time }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                No router logs found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
