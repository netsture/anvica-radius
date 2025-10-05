@extends('layouts.app')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Edit User</h4>
        </div>            
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label class="form-label">Role: <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $user->role) == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>

                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
<div class="mb-3">
                            <label class="form-label">Role: <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Select Role --</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="billing_coordinator" {{ old('role', $user->role) == 'billing_coordinator' ? 'selected' : '' }}>Billing Coordinator</option>
                                <option value="insurance_coordinator" {{ old('role', $user->role) == 'insurance_coordinator' ? 'selected' : '' }}>Insurance Coordinator</option>
                                <option value="office_manager" {{ old('role', $user->role) == 'office_manager' ? 'selected' : '' }}>Office Manager</option>
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', $user->mobile) }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Home</label>
                                    <input type="text" name="home" class="form-control @error('home') is-invalid @enderror" value="{{ old('home', $user->home) }}">
                                    @error('home')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Work</label>
                                    <input type="text" name="work" class="form-control @error('work') is-invalid @enderror" value="{{ old('work', $user->work) }}">
                                    @error('work')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        

                        <div class="mb-3">
                            <label class="form-label">Status: <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary me-2">Update User</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('users.index') }}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
