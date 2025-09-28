@extends('layouts.app')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Add Plan</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('plans.store') }}" method="post" class="forms-sample">
                            @csrf
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="srvname" class="form-control" value="{{ old('srvname') }}"
                                    required>
                                @error('srvname')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button class="btn btn-primary">Save</button>
                            <a href="{{ route('plans.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
