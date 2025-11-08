@extends('layouts.app')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap ">
            <div>
                <h4 class="mb-3 mb-md-0">Edit Room</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('rooms.update', $room->id) }}" method="post">
                            @csrf
                            @method('PUT')

                            {{-- Identity select (optional) --}}
                            <div class="mb-3">
                                <label class="form-label">Identity</label>
                                <select name="identity_id" class="form-select">
                                    <option value="">-- Select --</option>
                                    @foreach($identities as $identity)
                                        <option value="{{ $identity->id }}"
                                            {{ old('identity_id', $room->identity_id) == $identity->id ? 'selected' : '' }}>
                                            {{ $identity->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('identity_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Room No</label>
                                <input type="text" name="room_no" class="form-control"
                                    value="{{ old('room_no', $room->room_no) }}" required>
                                @error('room_no') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Floor No</label>
                                <input type="text" name="floor_no" class="form-control"
                                    value="{{ old('floor_no', $room->floor_no ?? '1') }}">
                                @error('floor_no') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Room Type</label>
                                <select name="room_type" class="form-select">
                                    <option value="single" {{ old('room_type', $room->room_type) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="double" {{ old('room_type', $room->room_type) == 'double' ? 'selected' : '' }}>Double</option>
                                    <option value="suite"  {{ old('room_type', $room->room_type) == 'suite'  ? 'selected' : '' }}>Suite</option>
                                </select>
                                @error('room_type') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="occupied"  {{ old('status', $room->status) == 'occupied'  ? 'selected' : '' }}>Occupied</option>
                                </select>
                                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <button class="btn btn-primary">Update Room</button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
