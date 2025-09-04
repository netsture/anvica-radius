@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="main-content d-flex justify-content-between flex-wrap">
        <h2 class="page-title">Options</h2>
        <div>
            <a href="{{ route('options.create') }}" class="btn btn-primary">
                <i class="btn-icon-prepend" data-feather="plus"></i> Add New
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="search_category" class="form-label">Filter by Category</label>
                            <select id="search_category" class="form-select">
                                <option value="">--Select--</option>                                                                
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Key</th>
                                    <th>Value</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $option->category }}</td>
                                    <td>{{ $option->key }}</td>
                                    <td>{{ $option->value }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('options.edit', $option->id) }}" class="btn btn-inverse-warning btn-xs">Edit</a>
                                        <a href="{{ route('options.delete', $option->id) }}" class="btn btn-inverse-danger btn-xs" id="delete">Delete</a>
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
