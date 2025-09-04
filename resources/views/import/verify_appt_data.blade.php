@extends('layouts.app')

@section('content')

<div class="page-content">
    @if($csvs->count() > 0)
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Imported Appt Data <code>Please verify & save data</code></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Clinic</th>
                                    <th>Appt. Provider</th>
                                    <th>Appt. Date</th>
                                    <th>Appt. Time</th>
                                    <th>Full Name</th>
                                    <th>Date of Birth</th>
                                    <th>Prim. Subscriber</th>
                                    <th>Prim. Carrier Name</th>
                                    <th>Prim. Subscriber ID</th>
                                    <th>Sec. Carrier Name</th>
                                    <th>Sec. Subscriber ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($csvs as $csv)
                                    <tr>
                                        <td>{{ $csv->id }}</td>
                                        <td>{{ $csv->clinic }}</td>
                                        <td>{{ $csv->appt_provider }}</td>
                                        <td>{{ $csv->appt_date }}</td>
                                        <td>{{ $csv->appt_time }}</td>
                                        <td>{{ $csv->full_name }}</td>
                                        <td>{{ $csv->date_of_birth }}</td>
                                        <td>{{ $csv->prim_subscriber }}</td>
                                        <td>{{ $csv->prim_carrier_name }}</td>
                                        <td>{{ $csv->prim_subscriber_id }}</td>
                                        <td>{{ $csv->sec_carrier_name }}</td>
                                        <td>{{ $csv->sec_subscriber_id }}</td>

                                    </tr>
                                    @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <button type="button" class="btn btn-primary" onclick="window.location='{{ route('import.appt.data.save') }}'">Verify & Save</button>
                                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard') }}'">Cancel</button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>    
    @endif
</div>
@endsection