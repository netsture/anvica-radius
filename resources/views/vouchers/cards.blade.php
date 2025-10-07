@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h2 class="page-title">Vouchers</h2>
            <div>
                <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">
                    << Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            @foreach($vouchers as $voucher)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm" style="border-radius: 12px; overflow:hidden; border: 2px solid #ccc;">
                                    <div style="background:red; color:white; padding:5px; font-weight:bold; text-align:center;">
                                        Prepaid Card
                                    </div>
                                    <div style="background:#f8f8f8; padding:10px;">
                                        <div style="font-size:18px; font-weight:bold; color:#007bff;">
                                            500 MB download traffic
                                        </div>
                                        <p style="margin:0;">User name: <strong>{{ $voucher->cardnum }}</strong></p>
                                        <p style="margin:0;">Password: <strong>{{ $voucher->password }}</strong></p>
                                        <p style="margin:0;">Valid till: {{ $voucher->expiration }}</p>
                                        <small>Series: {{ $voucher->series }}</small>
                                    </div>
                                    <div style="background:#eee; text-align:center; padding:5px; font-size:12px;">
                                        Powered by Anvica Hotspot
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
