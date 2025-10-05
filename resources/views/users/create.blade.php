@extends('layouts.app')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Create User</h4>
        </div>            
    </div>

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form action="{{ route('users.store') }}" method="POST" class="forms-sample">
                        @csrf

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label class="form-label">Role: <span class="text-danger">*</span></label>
                            <select id="role-select" name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>

                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Identity Dropdown -->
                        <div class="mb-3" id="identity-wrapper" style="display: none;">
                            <label class="form-label">Identity: <span class="text-danger">*</span></label>
                            <select name="identity_id" class="form-select @error('identity_id') is-invalid @enderror">
                                <option value="">-- Select Identity --</option>
                                @foreach($identities as $id => $name)
                                    <option value="{{ $id }}" {{ old('identity_id') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('identity_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                    

                        <div class="mb-3">
                            <label class="form-label">Userame <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control  @error('username') is-invalid @enderror" value="{{ old('username') }}">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
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
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
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
                                    <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Home</label>
                                    <input type="text" name="home" class="form-control @error('home') is-invalid @enderror" value="{{ old('home') }}">
                                    @error('home')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Work</label>
                                    <input type="text" name="work" class="form-control @error('work') is-invalid @enderror" value="{{ old('work') }}">
                                    @error('work')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Set Password: <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password: <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Status: <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Multiple select using select 2</label>
                            <select class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                <option value="TX">Texas</option>
                                <option value="WY">Wyoming</option>
                                <option value="NY">New York</option>
                                <option value="FL">Florida</option>
                                <option value="KN">Kansas</option>
                                <option value="HW">Hawaii</option>
                            </select>
                        </div> --}}
                        <button type="submit" class="btn btn-primary me-2">Save Changes </button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('users.index') }}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
    function toggleIdentityField() {
        let role = document.getElementById("role-select").value;
        let identityWrapper = document.getElementById("identity-wrapper");

        // Show only if role is provider or user
        if (role === "provider" || role === "user") {
            identityWrapper.style.display = "block";
        } else {
            identityWrapper.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        toggleIdentityField();
        document.getElementById("role-select").addEventListener("change", toggleIdentityField);
    });
</script>

@endsection


