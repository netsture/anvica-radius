@extends('layouts.app')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Add Plan</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('plans.store') }}" method="post" class="forms-sample">
                            @csrf

                            <!-- Identity -->
                            <div class="mb-3">
                                <label class="form-label">Identity <span class="text-danger">*</span></label>
                                <select name="identity_id" class="form-select @error('identity_id') is-invalid @enderror">
                                    <option value="">-- Select Identity --</option>
                                    @foreach($identities as $id => $name)
                                        <option value="{{ $id }}" {{ old('identity_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('identity_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" name="srvname" class="form-control @error('srvname') is-invalid @enderror" value="{{ old('srvname') }}">
                                @error('srvname') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="descr" class="form-control @error('descr') is-invalid @enderror">{{ old('descr') }}</textarea>
                                @error('descr') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data Rate (DL) <span class="text-danger">*</span></label>
                                <input type="text" name="downrate" placeholder="e.g. 5M" class="form-control @error('downrate') is-invalid @enderror" value="{{ old('downrate', 0) }}">
                                @error('downrate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data Rate (UL) <span class="text-danger">*</span></label>
                                <input type="text" name="uprate" placeholder="e.g. 1M" class="form-control @error('uprate') is-invalid @enderror" value="{{ old('uprate', 0) }}">
                                @error('uprate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <button class="btn btn-primary">Save</button>
                            <a href="{{ route('plans.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
