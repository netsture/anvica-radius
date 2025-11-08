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
                            <label class="form-label">Identity</label>
                            <select name="identity_id" class="form-select">
                                <option value="">-- Select --</option>
                                @foreach($identities as $identity)
                                    <option value="{{ $identity->id }}">{{ $identity->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Room No</label>
                            <input type="text" name="room_no" class="form-control" value="{{ old('room_no') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Floor No</label>
                            <input type="text" name="floor_no" class="form-control" value="{{ old('floor_no', '1') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Room Type</label>
                            <select name="room_type" class="form-select">
                                <option value="single">Single</option>
                                <option value="double">Double</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                            </select>
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
