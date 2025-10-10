@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Vouchers</h2>
            <div>
                <a href="{{ route('vouchers.create') }}" class="btn btn-primary">
                    Generate Vouchers
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
                                        <th>Series</th>
                                        <th>Service plan</th>
                                        <th>Quantity</th>
                                        <th>Validity</th>
                                        <th>Generated on</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($vouchers as $voucher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voucher->series }}</td>
                                            <td>{{ $voucher->plan->srvname ?? 'N/A' }}</td>
                                            <td>{{ $voucher->total }}</td>
                                            <td>{{ $voucher->valid_days." Days" }}</td>
                                            <td>{{ $voucher->created_at }}</td>
                                            <td>{{ ucfirst($voucher->status) }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('vouchers.cards', $voucher->series) }}" class="btn btn-inverse-warning btn-xs">View</a>
                                                <a href="{{ route('vouchers.downloadPdf', $voucher->series) }}" target="_blank" class="btn btn-inverse-danger btn-xs">PDF</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No data found</td>
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
