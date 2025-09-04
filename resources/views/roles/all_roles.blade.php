@extends('layouts.app')
@section('content') 

<div class="page-content">
    
    <div class="main-content d-flex justify-content-between flex-wrap">
        <h2 class="page-title">Roles</h2>
        <div>
            <a href="{{ route('add.roles') }}" class="btn btn-primary mb-2 mb-md-0 ms-3"><i class="btn-icon-prepend" data-feather="plus"></i> Add New</a>  
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table" id="dataTableExample">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Roles Name </th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $item ) 
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('edit.roles',$item->id) }}" class="btn btn-inverse-warning btn-xs"> Edit</a>
                                        <a href="{{ route('delete.roles',$item->id) }}" class="btn btn-inverse-danger btn-xs" id="delete"> Delete</a>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</div>
@endsection