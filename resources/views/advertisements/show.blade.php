<!-- resources/views/advertisements/show.blade.php -->
@extends('layouts.app')
@section('title','View Advertisement')
@section('content')
<div class="row">
  <div class="col-md-5">
    @if($ad->image_path)
      <img src="{{ asset('storage/'.$ad->image_path) }}" class="img-fluid mb-3">
    @endif
  </div>
  <div class="col-md-7">
    <h4>{{ $ad->title }}</h4>
    <p>Status: <strong>{{ $ad->status }}</strong></p>
    <p>Time slot: <strong>{{ $ad->time_slot }}</strong></p>
    <p>Weekdays: <strong>{{ $ad->weekdays ? implode(', ', $ad->weekdays) : 'All' }}</strong></p>
    <p>Schedule: {{ optional($ad->start_at)->toDayDateTimeString() }} → {{ optional($ad->end_at)->toDayDateTimeString() }}</p>
    <p>Click URL: <a href="{{ $ad->click_url }}" target="_blank" rel="noopener">{{ $ad->click_url }}</a></p>
    <p>Geo: {{ $ad->country ?? '*' }} / {{ $ad->state ?? '*' }} / {{ $ad->city ?? '*' }} / {{ $ad->zone ?? '*' }} / {{ $ad->area ?? '*' }} / {{ $ad->society ?? '*' }}</p>
    <p>Priority: {{ $ad->priority }}</p>
  </div>
</div>
@endsection
