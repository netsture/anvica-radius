@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-3">
        <h4 class="mb-0">Create Room</h4>
        <div>
            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Identity <span class="text-danger">*</span></label>
                            <select name="identity_id" class="form-select @error('identity_id') is-invalid @enderror">
                                <option value="">-- Select --</option>
                                @foreach($identities as $identity)
                                    <option value="{{ $identity->id }}" {{ old('identity_id', auth()->user()->identity_id ?? '') == $identity->id ? 'selected' : '' }}>{{ $identity->name }}</option>
                                @endforeach
                            </select>
                            @error('identity_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Room No <span class="text-danger">*</span></label>
                            <input type="text" name="room_no" class="form-control @error('room_no') is-invalid @enderror" value="{{ old('room_no') }}" maxlength="4">
                            @error('room_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Floor No <span class="text-danger">*</span></label>
                            <input type="text" name="floor_no" class="form-control @error('floor_no') is-invalid @enderror" value="{{ old('floor_no', '1') }}">
                            @error('floor_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Room Type <span class="text-danger">*</span></label>
                            <select name="room_type" class="form-select @error('room_type') is-invalid @enderror">
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                            @error('room_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', '1') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button class="btn btn-primary">Save Room</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
