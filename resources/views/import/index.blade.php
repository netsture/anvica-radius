@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Import CSV File</h4>                
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('import.eligibility.patient.create') }}" method="POST" id="myForm" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select File:</label>
                            <input type="file" name="file" class="form-control" required>
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Import</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard') }}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($csvs->count() > 0)
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Last Imported Data</h6>
                    <p class="text-muted mb-3"><code>Please verify data and save</code></p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FullName</th>
                                    <th>Date of Birth</th>
                                    <th>Prim. Carrier Name</th>
                                    <th>Prim. Subscriber ID</th>
                                    <th>Provider Full Name</th>
                                    <th>Billing Date</th>
                                    <th>Procedure Code</th>
                                    <th>Tooth</th>
                                    <th>Surfaces</th>
                                    <th>Quadrant</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($csvs as $csv)
                                    <tr>
                                        <td>{{ $csv->id }}</td>
                                        <td>{{ $csv->full_name }}</td>
                                        <td>{{ $csv->dob }}</td>
                                        <td>{{ $csv->insurance_name }}</td>
                                        <td>{{ $csv->subscriber_id }}</td>
                                        <td>{{ $csv->provider_full_name }}</td>
                                        <td>{{ $csv->billing_date }}</td>
                                        <td>{{ $csv->procedure_code }}</td>
                                        <td>{{ $csv->tooth }}</td>
                                        <td>{{ $csv->surface }}</td>
                                        <td>{{ $csv->quadrant }}</td>
                                        <td>{{ $csv->cost }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12"><button type="button" class="btn btn-primary">Save Data</button></td>
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
