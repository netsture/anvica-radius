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

                                        <!-- New location fields -->
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Zone</th>
                                        <th>Area</th>

                                        <th>Society</th>
                                        <th>OTP</th>

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

                                            <!-- show new fields (null-safe) -->
                                            <td>{{ $identity->country ?? '-' }}</td>
                                            <td>{{ $identity->state ?? '-' }}</td>
                                            <td>{{ $identity->city ?? '-' }}</td>
                                            <td>{{ $identity->zone ?? '-' }}</td>
                                            <td>{{ $identity->area ?? '-' }}</td>

                                            <td>{{ $identity->society ? ucfirst($identity->society) : '-' }}</td>

                                            <td>
                                                {{-- Show OTP options as badges if enabled --}}
                                                @if($identity->otp_sms) <span class="badge bg-info">SMS</span> @endif
                                                @if($identity->otp_whatsapp) <span class="badge bg-success">WhatsApp</span> @endif
                                                @if($identity->otp_email) <span class="badge bg-secondary">Email</span> @endif

                                                {{-- if none selected show: '-' --}}
                                                @if(!$identity->otp_sms && !$identity->otp_whatsapp && !$identity->otp_email)
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <td>{{ optional($identity->creator)->name ?? $identity->created_by }}</td>
                                            <td>{{ $identity->created_at }}</td>
                                            <td>{{ optional($identity->updatedBy)->name ?? $identity->updated_by }}</td>
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
                                            <td colspan="15">No identities found.</td>
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
