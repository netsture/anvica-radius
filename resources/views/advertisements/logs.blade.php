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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12">
                            <form class="row g-2 mb-3" method="get">
                                <div class="col-md-4">
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                        placeholder="Search title...">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">All status</option>
                                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


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
                                                    @if ($ad->image_path)
                                                        <img src="{{ asset('../' . $ad->image_path) }}" alt="Ad Image"
                                                            class="wd-80 rounded-circle"
                                                            style="cursor:pointer; width:80px; height:80px; object-fit:cover;"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                                            data-image="{{ asset('../' . $ad->image_path) }}">
                                                    @endif
                                                </td>

                                                <td>{{ $ad->title }}</td>
                                                <td>{{ $ad->click_url }}</td>
                                                <td>
                                                    {{ optional($ad->start_at)->format('Y-m-d H:i') }}<br />
                                                    {{ optional($ad->end_at)->format('Y-m-d H:i') }}
                                                </td>
                                                <td>{{ $ad->view_count }}</td>
                                                <td>{{ $ad->click_count }}</td>
                                                @php
                                                    $isExpired = $ad->end_at && $ad->end_at <= now();
                                                @endphp
                                                <td>
                                                    @if ($isExpired)
                                                        <span class="badge text-bg-warning">Expired</span>
                                                    @else
                                                        <span class="badge text-bg-{{ $ad->status === 'Active' ? 'success' : 'danger' }}">
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

@endsection
