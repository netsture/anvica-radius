@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Advertise</h2>
            <div>
                <a href="{{ route('identities.create') }}" class="btn btn-primary">
                    <i class="btn-icon-prepend" data-feather="plus"></i> Add New
                </a>
            </div>
        </div>

        
    </div>
@endsection
