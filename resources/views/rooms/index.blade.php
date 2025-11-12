@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Rooms</h2>
            <div>
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    Create Room
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
                                        <th>Identity</th>
                                        <th>Room No</th>
                                        <th>Floor No</th>
                                        <th>Room Type</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rooms as $room)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $room->identity->name ?? 'Admin' }}</td>
                                            <td>{{ $room->room_no }}</td>
                                            <td>{{ $room->floor_no ?? '-' }}</td>
                                            <td>{{ $room->room_type ?? '-' }}</td>
                                            <td>
                                                @if($room->status === '1')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-inverse-warning btn-xs">Edit</a>

                                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete room {{ $room->room_no }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-inverse-danger btn-xs">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No rooms found</td>
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
