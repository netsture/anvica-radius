@php
    $statusOptions = $statusOptions ?? ['draft', 'active', 'paused', 'expired'];
    $slotOptions = $slotOptions ?? ['all', 'morning', 'afternoon', 'evening', 'night'];
    $weekdayOptions = $weekdayOptions ?? ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    // prefill datetime-local inputs
    $startValue = old('start_at', optional($ad->start_at)->format('Y-m-d\TH:i'));
    $endValue = old('end_at', optional($ad->end_at)->format('Y-m-d\TH:i'));

    // selected geo values for preload
    $selCountry = old('country', $ad->country ?? 'India');
    $selState = old('state', $ad->state ?? '');
    $selCity = old('city', $ad->city ?? '');
    $selZone = old('zone', $ad->zone ?? '');
    $selArea = old('area', $ad->area ?? '');
    $selSociety = old('society', $ad->society ?? '');
@endphp
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Advertiser <span class="text-danger">*</span></label>
    <select name="advertiser_id" class="form-select @error('advertiser_id') is-invalid @enderror">
        <option value="">-- Select Advertiser --</option>
        @foreach ($advertisers as $advertiser)
            <option value="{{ $advertiser->id }}"
                {{ old('advertiser_id', $ad->advertiser_id ?? '') == $advertiser->id ? 'selected' : '' }}>{{ $advertiser->username." [".$advertiser->first_name." ".$advertiser->last_name."]" }}
            </option>
        @endforeach
    </select>
    @error('advertiser_id') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Images/Video Title *</label>
    <input type="text" name="title" value="{{ old('title', $ad->title) }}" class="form-control @error('title') is-invalid @enderror">
    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Image/Video {{ $ad->exists ? '(leave empty to keep)' : '*' }}</label>
    <input type="file" name="media" id="media" class="form-control" @if (!$ad->exists) @endif accept="image/*, video/*">
    <small class="text-muted">
        Allowed: jpg, jpeg, png, gif, mp4, mov, webm, webp, avif | Max size: 5MB
    </small>
    @if ($ad->media_path)
        <small class="text-muted d-block mt-1">Current: {{ $ad->media_path }}</small>
    @endif
</div>

<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label"> </label>
    <img id="showImage" class="wd-80 rounded-circle"
        src="{{ !empty($ad->media_path) ? asset('../' . $ad->media_path) : asset('images/admin/placeholder.jpg') }}"
        alt="profile">
</div>

<div class="mb-3">
    <label class="form-label">Page Section</label>
    <select name="page_section" class="form-control">
        <option value="">Select Page Section</option>
        @foreach(config('page_sections') as $key => $label)
            <option value="{{ $key }}" {{ old('page_section', $ad->page_section ?? '') == $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Image Click URL</label>
    <input type="text" name="click_url" value="{{ old('click_url', $ad->click_url) }}" class="form-control"
        placeholder="https://...">
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Start Date</label>
        <input type="datetime-local" name="start_at" value="{{ $startValue }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">End Date</label>
        <input type="datetime-local" name="end_at" value="{{ $endValue }}" class="form-control">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Time slot *</label>
        <select name="time_slot" class="form-select" required>
            @foreach ($slotOptions as $s)
                <option value="{{ $s }}" @selected(old('time_slot', $ad->time_slot ?? 'all') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <small class="text-muted">Morning 6–12, Afternoon 12–18, Evening 18–24, Night 0–6</small>
    </div>
</div>

<div class="row mb-3">

    <div class="col-md-9">
        <label class="form-label">Weekdays <small class="text-muted text-danger">(Keep empty for all
                days)</small></label>
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
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Priority</label>
        <input type="number" name="priority" value="{{ old('priority', $ad->priority ?? '') }}" class="form-control"
            min="1" max="1000">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Max impressions</label>
        <input type="number" name="max_impressions" value="{{ old('max_impressions', $ad->max_impressions) }}"
            class="form-control" min="1">
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">Max clicks</label>
        <input type="number" name="max_clicks" value="{{ old('max_clicks', $ad->max_clicks) }}" class="form-control"
            min="1">
    </div>
</div>

<!-- Cascading geo fields: Country -> State -> City -> Zone(add) -> Area(add) -> Society(text) -->
<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Country</label>
        <select id="country" name="country" class="form-select">
            <option value="">-- Select Country --</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">State</label>
        <select id="state" name="state" class="form-select">
            <option value="">-- Select State --</option>
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">City</label>
        <select id="city" name="city" class="form-select">
            <option value="">-- Select City --</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Zone</label>
        <div class="d-flex">
            <select id="zone" name="zone" class="form-select">
                <option value="">-- Select Zone --</option>
            </select>
            <input id="newZoneInput" type="text" class="form-control ms-2"
                placeholder="Add zone (if not listed)">
            <button id="addZoneBtn" type="button" class="btn btn-outline-primary ms-2">Add</button>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Area</label>
        <div class="d-flex">
            <select id="area" name="area" class="form-select">
                <option value="">-- Select Area --</option>
            </select>
            <input id="newAreaInput" type="text" class="form-control ms-2"
                placeholder="Add area (if not listed)">
            <button id="addAreaBtn" type="button" class="btn btn-outline-primary ms-2">Add</button>
        </div>
    </div>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">Society</label>
    <input type="text" name="society" value="{{ $selSociety }}" class="form-control"
        placeholder="Society">
</div>

<div class="mb-3">
    <label class="form-label">Status <span class="text-danger">*</span></label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        <option value="Active" {{ old('status', 'Active') == 1 ? 'selected' : '' }}>Active</option>
        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('status')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#media').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>