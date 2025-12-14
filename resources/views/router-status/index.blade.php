@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Router Status</h2>
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
                                        <th>Router</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>IP Address</th>
                                        <th>Logged At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr>
                                            <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>

                                            <td>
                                                <strong>{{ $log->router }}</strong>
                                            </td>

                                            <td>
                                                @if($log->status === 'UP')
                                                    <span class="badge bg-success">UP</span>
                                                @else
                                                    <span class="badge bg-danger">DOWN</span>
                                                @endif
                                            </td>

                                            <td>{{ now()->toDateString() }}</td>
                                            <td>{{ now()->toTimeString() }}</td>

                                            <td>{{ $log->ip_address ?? '-' }}</td>

                                            <td class="text-muted small">
                                                {{ $log->created_at->format('d M Y H:i:s') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                No router logs found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $logs->links() }}
    </div>
            </div>
        </div>
    </div>
@endsection
