@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Identities</h2>
            <div>
                <a href="{{ route('identities.create') }}" class="btn btn-primary">
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
                                        <th>Name</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Updated By</th>
                                        <th>Updated Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($identities as $identity)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $identity->name }}</td>
                                            <td>{{ optional($identity->creator)->name ?? $identity->created_by }}</td>
                                            <td>{{ $identity->created_at }}</td>
                                            <td>{{ optional($identity->creator)->name ?? $identity->created_by }}</td>
                                            <td>{{ $identity->updated_at }}</td>
                                            <td>
                                                @if ($identity->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif  
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('identities.edit', $identity->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('identities.destroy', $identity->id) }}"
                                                    method="POST" style="display:inline-block"
                                                    onsubmit="return confirm('Delete this identity?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No identities found.</td>
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
