@extends('layouts.app')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Generate Voucher</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('vouchers.generate') }}" method="POST">
                            @csrf

                            <!-- Identity Plan -->
                            <div class="mb-3">
                                <label class="form-label">Identity</label>
                                <select name="identity_id" class="form-select">
                                    <option value="">-- Select --</option>
                                    @foreach ($identities as $identity)
                                        <option value="{{ $identity->id }}"
                                            {{ old('identity_id', auth()->user()->identity_id ?? '') == $identity->id ? 'selected' : '' }}>{{ $identity->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service Plan -->
                            <div class="mb-3">
                                <label class="form-label">Service Plan</label>
                                <select name="srvid" class="form-select">
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->srvid }}"
                                            {{ old('srvid') == $plan->srvid ? 'selected' : '' }}>{{ $plan->srvname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}"
                                    min="1" @error('quantity') is-invalid @enderror>
                                @error('quantity')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Valid days -->
                            <div class="mb-3">
                                <label class="form-label">Valid Days</label>
                                <input type="number" name="valid_days" class="form-control"
                                    value="{{ old('valid_days') }}" min="1" @error('valid_days') is-invalid @enderror>
                                @error('valid_days')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Prefix -->
                            <div class="mb-3">
                                <label class="form-label">Prefix</label>
                                <input type="text" name="prefix" class="form-control" value="{{ old('prefix', '') }}">
                                @error('prefix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Voucher Code Length -->
                            <div class="mb-3">
                                <label class="form-label">Voucher Code Length</label>
                                <select name="pin_length" class="form-select">
                                    @for ($i = 4; $i <= 16; $i++)
                                        <option value="{{ $i }}" {{ old('pin_length') == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label">Password Length</label>
                                <select name="password_length" class="form-select">
                                    @for ($i = 4; $i <= 8; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('password_length') == $i ? 'selected' : '' }}>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div> 

                            <div class="mb-3">
                                <label class="form-label">Download Limit</label>
                                <input type="number" name="downlimit" class="form-control"
                                    value="{{ old('downlimit', 0) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Limit</label>
                                <input type="number" name="uplimit" class="form-control" value="{{ old('uplimit', 0) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Total Limit</label>
                                <input type="number" name="comblimit" class="form-control"
                                    value="{{ old('comblimit', 0) }}">
                            </div>--}}
                            <button class="btn btn-primary me-2">Submit</button>
                            <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
