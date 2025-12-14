@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">Edit Identity</h3>
            <div>
                <a href="{{ route('identities.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('identities.update', $identity->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $identity->name) }}" required>
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>MAC Address</label>
                                    <input type="text" id="mac" name="mac" class="form-control" value="{{ old('mac', $identity->mac) }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Model</label>
                                    <input type="text" id="model" name="model" class="form-control" value="{{ old('model', $identity->model) }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Serial</label>
                                    <input type="text" id="serial" name="serial" class="form-control" value="{{ old('serial', $identity->serial) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', $identity->status)==1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status', $identity->status)=='0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('identities.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

