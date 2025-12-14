@if (empty($datas) || $datas->isEmpty())
    <p class="text-muted">No Data Found</p>
@else
    <div class="d-flex justify-content-between mb-2">
        {{-- <a href="{{ route('radius.users.logs.export', ['ad_id' => $ad_id]) }}" 
           class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Export to Excel
        </a> --}}
    </div>

    <table class="table table-bordered table-sm" style="font-size: 14px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>MAC</th>
                <th>Ipaddress</th>
                <th>Click Url</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ viewDateTime($data->clicked_at) ?? '-' }}</td>
                    <td>{{ $data->mac ?? 'N/A' }}</td>
                    <td>{{ $data->ip ?? 'N/A' }}</td>
                    <td>{{ $data->redirect_url ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
