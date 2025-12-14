<!-- resources/views/advertisements/create.blade.php -->
@extends('layouts.app')
@section('title', 'Create Advertisement')
@section('content')

    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">Create Advertise</h3>
            <div>
                <a href="{{ route('advertisements.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{-- ================= ADVERTISER ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Advertiser</label>
                            <div>
                                {{ $ad->advertiser->username ?? '-' }}
                                [{{ $ad->advertiser->first_name ?? '' }} {{ $ad->advertiser->last_name ?? '' }}]
                            </div>
                        </div>

                        {{-- ================= TITLE ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Title</label>
                            <div>{{ $ad->title }}</div>
                        </div>

                        {{-- ================= MEDIA ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Media</label>
                            <div class="mt-2">
                                @if ($ad->media_type === 'image')
                                    <img src="{{ asset('../' . $ad->media_path) }}" class="img-thumbnail"
                                        style="max-width:300px;">
                                @elseif($ad->media_type === 'video')
                                    <video width="320" controls>
                                        <source src="{{ asset('../' . $ad->media_path) }}">
                                    </video>
                                @else
                                    <span class="text-muted">No media</span>
                                @endif
                            </div>
                        </div>

                        {{-- ================= PAGE SECTION ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Page Section</label>
                            <div>
                                {{ config('page_sections.' . $ad->page_section) ?? '-' }}
                            </div>
                        </div>

                        {{-- ================= CLICK URL ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Click URL</label>
                            <div>
                                @if ($ad->click_url)
                                    <a href="{{ $ad->click_url }}" target="_blank">
                                        {{ $ad->click_url }}
                                    </a>
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        {{-- ================= DATE & TIME ================= --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Start Date</label>
                                <div>{{ $ad->start_at ? $ad->start_at->format('d M Y H:i') : '-' }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">End Date</label>
                                <div>{{ $ad->end_at ? $ad->end_at->format('d M Y H:i') : '-' }}</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Time Slot</label>
                                <div>{{ ucfirst($ad->time_slot) }}</div>
                            </div>
                        </div>

                        {{-- ================= WEEKDAYS ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Weekdays</label>
                            <div>
                                @if (empty($ad->weekdays))
                                    All days
                                @else
                                    {{ implode(', ', array_map('strtoupper', $ad->weekdays)) }}
                                @endif
                            </div>
                        </div>

                        {{-- ================= LIMITS ================= --}}
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Priority</label>
                                <div>{{ $ad->priority }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Max Impressions</label>
                                <div>{{ $ad->max_impressions ?? '-' }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="fw-bold">Max Clicks</label>
                                <div>{{ $ad->max_clicks ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- ================= LOCATION ================= --}}
                        <div class="mb-3">
                            <label class="fw-bold">Location</label>
                            <div>
                                {{ collect([$ad->country, $ad->state, $ad->city, $ad->zone, $ad->area, $ad->society])->filter()->implode(', ') ?:
                                    '-' }}
                            </div>
                        </div>

                        {{-- ================= STATUS ================= --}}                        
                        <div class="mb-3">
                            <label class="fw-bold">Status</label>
                            <span class="badge {{ $ad->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $ad->status }}
                            </span>
                        </div>
                        <div class="mb-3">
                          <a href="{{ route('advertisements.index') }}" class="btn btn-secondary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
