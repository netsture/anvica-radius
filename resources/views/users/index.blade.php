@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="main-content d-flex justify-content-between flex-wrap">
        <h2 class="page-title">Users</h2>
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
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
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Mobile</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th  class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ viewDate($user->dob) }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="badge bg-primary">{{ ucfirst($role) }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif    
                                    </td>
                                    <td  class="text-end">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-inverse-warning btn-xs">Edit</a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-danger btn-xs" onclick="return confirm('Are you sure you want to delete this?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
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
