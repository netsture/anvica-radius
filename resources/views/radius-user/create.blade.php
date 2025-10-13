@extends('layouts.app')

@section('content')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Create Hotspot User</h4>
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
                    <form action="{{ route('radius.users.store') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="mb-3" id="identity-wrapper">
                            <label class="form-label">Identity: <span class="text-danger">*</span></label>
                            <select name="identity_id" class="form-select @error('identity_id') is-invalid @enderror">
                                @if(empty(auth()->user()->identity_id))
                                <option value="">-- Select Identity --</option>
                                @endif
                                @foreach($identities as $identity)
                                    <option value="{{ $identity->id }}" {{ old('identity_id') == $identity->id ? 'selected' : '' }}>
                                        {{ $identity->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('identity_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Service Plan -->
                        <div class="mb-3">
                            <label class="form-label">Service Plan: <span class="text-danger">*</span></label>
                            <select name="srvid" class="form-select">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->srvid }}"
                                        {{ old('srvid') == $plan->srvid ? 'selected' : '' }}>{{ $plan->srvname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Userame <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control  @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Password: <span class="text-danger">*</span></label>
                                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"  value="{{ old('password') }}" required>
                                    @error('password')
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
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
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
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
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

                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('radius.users.index') }}'">Cancel</button>
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


