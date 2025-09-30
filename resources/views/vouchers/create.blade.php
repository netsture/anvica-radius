@extends('layouts.app')

@section('content')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Create Voucher</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('vouchers.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Card Number</label>
                                <input type="text" name="cardnum" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Value</label>
                                <input type="number" step="0.01" name="value" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Expiration</label>
                                <input type="date" name="expiration" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Series</label>
                                <input type="text" name="series" class="form-control" required>
                            </div>
                            <button class="btn btn-success">Save</button>
                            <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
