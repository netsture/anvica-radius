@extends('layouts.db')

@section('content')

<div class="page-content">
    <div class="row">
            
                    
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                @foreach($columns as $col)
                                    <th>{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    @foreach($columns as $col)
                                        <td>{{ $row->$col }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
</div>

@endsection

