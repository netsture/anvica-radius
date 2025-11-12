@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Plans</h2>
            <div>
                <a href="{{ route('plans.create') }}" class="btn btn-primary">
                    Create Plan
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table" id="dataTableExample"  data-display-length="100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Identity</th>
                                        <th>Service plan</th>
                                        <th>DL rate (kbps)</th>
                                        <th>UL rate (kbps)</th>
                                        <th>Download limit</th>
                                        <th>Upload limit</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($datas as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->identity->name ?? 'Admin' }}</td>
                                            <td>{{ $data->srvname }}</td>
                                            <td>{{ $data->downrate > 0 ?  $data->downrate : 'N/A'}}</td>
                                            <td>{{ $data->uprate > 0 ?  $data->uprate : 'N/A'}}</td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-end">
                                                <a href="{{ route('plans.edit', $data->srvid) }}" class="btn btn-inverse-warning btn-xs">Edit</a>

                                                <form action="{{ route('plans.destroy', $data->srvid) }}"
                                                    method="POST" style="display:inline-block"
                                                    onsubmit="return confirm('Delete this identity?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-inverse-danger btn-xs">Delete</button>
                                                </form>
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
