<!-- resources/views/advertisements/index.blade.php -->
@extends('layouts.app')
@section('title', 'Advertisements')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">Advertisements</h3>
            <div>
                <a href="{{ route('advertisements.create') }}" class="btn btn-primary btn-sm">Create Ads.</a>
            </div>
        </div>

        <div class="row">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table" id="dataTableExample" data-display-length="100"
                                    style="font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Preview</th>
                                            <th>Title</th>
                                            <th>Click URL</th>
                                            <th>Duration</th>
                                            <th>View Count</th>
                                            <th>Click Count</th>
                                            <th class="text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ads as $ad)
                                            <tr>
                                                <td>{{ $ad->id }}</td>
                                                <td style="width:120px">
                                                    @if ($ad->media_path)
                                                        <img src="{{ asset('../' . $ad->media_path) }}" alt="Ad Image"
                                                            class="wd-80 rounded-circle"
                                                            style="cursor:pointer; width:80px; height:80px; object-fit:cover;"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                                            data-image="{{ asset('../' . $ad->media_path) }}">
                                                    @endif
                                                </td>

                                                <td>{{ $ad->title }}</td>
                                                <td>{{ $ad->click_url }}</td>
                                                <td>
                                                    {{ optional($ad->start_at)->format('Y-m-d H:i') }}<br />
                                                    {{ optional($ad->end_at)->format('Y-m-d H:i') }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-light  viewCountLogsBtn"
                                                        data-ad_id="{{ $ad->id }}" data-event="view">
                                                        {{ $ad->view_count }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-light  viewClickLogsBtn"
                                                        data-ad_id="{{ $ad->id }}" data-event="click">
                                                        {{ $ad->click_count }}
                                                    </button>
                                                </td>
                                                @php
                                                    $isExpired = $ad->end_at && $ad->end_at <= now();
                                                @endphp
                                                <td>
                                                    @if ($isExpired)
                                                        <span class="badge text-bg-warning">Expired</span>
                                                    @else
                                                        <span
                                                            class="badge text-bg-{{ $ad->status === 'Active' ? 'success' : 'danger' }}">
                                                            {{ $ad->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted">No ads found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <!-- User Log History Modal -->
                                <div class="modal fade" id="userLogModal" tabindex="-1" aria-labelledby="userLogModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="userLogModalLabel">Advertisement History</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="userLogsContent" class="table-responsive text-center">
                                                <p class="text-muted">Loading logs...</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center p-0">
                    <img id="modalImage" src="" class="img-fluid rounded shadow-lg" alt="Full Image">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const trigger = event.relatedTarget;
                const imageUrl = trigger.getAttribute('data-image');
                const modalImg = imageModal.querySelector('#modalImage');
                modalImg.src = imageUrl;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.viewCountLogsBtn, .viewClickLogsBtn').click(function() {
                // let userId = $(this).data('user-id');
                let ad_id = $(this).data('ad_id');
                let event = $(this).data('event');
                // $('#userLogModalLabel').text('Log History - ' + username);
                $('#userLogsContent').html('<p class="text-muted">Loading logs...</p>');
                $('#userLogModal').modal('show');

                $.ajax({
                    url: "{{ route('advertisements.logs.history') }}",
                    type: 'GET',
                    data: {
                        ad_id: ad_id,
                        event: event
                    },
                    success: function(response) {
                        // console.log('User Log Response:', response); // ✅ log response in console
                        $('#userLogsContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error); // ✅ log error message
                        console.log('Response Text:', xhr.responseText); // ✅ full error output
                        $('#userLogsContent').html(
                            '<p class="text-danger">Failed to load logs.</p>');
                    }
                });
            });
        });
    </script>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
