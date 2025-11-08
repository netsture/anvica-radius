<!-- resources/views/advertisements/_form.blade.php -->
@php
    $statusOptions = $statusOptions ?? ['draft', 'active', 'paused', 'expired'];
    $slotOptions = $slotOptions ?? ['all', 'morning', 'afternoon', 'evening', 'night'];
    $weekdayOptions = $weekdayOptions ?? ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    // prefill datetime-local inputs
    $startValue = old('start_at', optional($ad->start_at)->format('Y-m-d\TH:i'));
    $endValue = old('end_at', optional($ad->end_at)->format('Y-m-d\TH:i'));
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title *</label>
        <input type="text" name="title" value="{{ old('title', $ad->title) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Image {{ $ad->exists ? '(leave empty to keep)' : '*' }}</label>
        <input type="file" name="image" class="form-control" @if (!$ad->exists) required @endif
            accept="image/*">
        @if ($ad->image_path)
            <small class="text-muted d-block mt-1">Current: {{ $ad->image_path }}</small>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label">Click URL</label>
        <input type="url" name="click_url" value="{{ old('click_url', $ad->click_url) }}" class="form-control"
            placeholder="https://...">
    </div>

    <div class="col-md-6">
        <label class="form-label">Start at</label>
        <input type="datetime-local" name="start_at" value="{{ $startValue }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">End at</label>
        <input type="datetime-local" name="end_at" value="{{ $endValue }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Time slot *</label>
        <select name="time_slot" class="form-select" required>
            @foreach ($slotOptions as $s)
                <option value="{{ $s }}" @selected(old('time_slot', $ad->time_slot ?? 'all') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <small class="text-muted">Morning 6–12, Afternoon 12–18, Evening 18–24, Night 0–6</small>
    </div>

    <div class="col-md-8">
        <label class="form-label">Weekdays</label>
        <div class="d-flex flex-wrap gap-2">
            @php
                $sel = collect(old('weekdays', $ad->weekdays ?? []))
                    ->map(fn($v) => strtolower($v))
                    ->all();
            @endphp
            @foreach ($weekdayOptions as $wd)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="wd_{{ $wd }}" name="weekdays[]"
                        value="{{ $wd }}" {{ in_array($wd, $sel) ? 'checked' : '' }}>
                    <label class="form-check-label" for="wd_{{ $wd }}">{{ strtoupper($wd) }}</label>
                </div>
            @endforeach
            <small class="text-muted d-block">Keep empty = all days</small>
        </div>
    </div>

    <div class="col-md-2">
        <label class="form-label">Priority</label>
        <input type="number" name="priority" value="{{ old('priority', $ad->priority ?? 5) }}" class="form-control"
            min="1" max="1000">
    </div>
    <div class="col-md-5">
        <label class="form-label">Max impressions</label>
        <input type="number" name="max_impressions" value="{{ old('max_impressions', $ad->max_impressions) }}"
            class="form-control" min="1">
    </div>
    <div class="col-md-5">
        <label class="form-label">Max clicks</label>
        <input type="number" name="max_clicks" value="{{ old('max_clicks', $ad->max_clicks) }}" class="form-control"
            min="1">
    </div>

    <div class="col-md-12">
        <hr>
    </div>

    <div class="col-md-4">
        <label class="form-label">Country</label>
        <input type="text" name="country" value="{{ old('country', $ad->country) }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">State</label>
        <input type="text" name="state" value="{{ old('state', $ad->state) }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city" value="{{ old('city', $ad->city) }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Zone</label>
        <input type="text" name="zone" value="{{ old('zone', $ad->zone) }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label class="form-label">Area</label>
        <input type="text" name="area" value="{{ old('area', $ad->area) }}" class="form-control">
    </div>
    <div class="col-md-4">
      <label class="form-label">Society</label>
      <input type="text" name="society" value="{{ old('society', $ad->society) }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select" required>
            @foreach ($statusOptions as $s)
                <option value="{{ $s }}" @selected(old('status', $ad->status) === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</div>
