<!-- resources/views/advertisements/create.blade.php -->
@extends('layouts.app')
@section('title', 'Create Advertisement')

@section('content')

    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Create Advertisement</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('advertisements.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @include('advertisements._form', ['ad' => $ad])

                            <button class="btn btn-primary me-2">Save</button>
                            <a href="{{ route('advertisements.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
