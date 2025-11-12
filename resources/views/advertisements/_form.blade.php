{{-- <!-- resources/views/advertisements/_form.blade.php -->
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
</div> --}}
<!-- resources/views/advertisements/_form.blade.php -->
@php
    $statusOptions = $statusOptions ?? ['draft', 'active', 'paused', 'expired'];
    $slotOptions = $slotOptions ?? ['all', 'morning', 'afternoon', 'evening', 'night'];
    $weekdayOptions = $weekdayOptions ?? ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    // prefill datetime-local inputs
    $startValue = old('start_at', optional($ad->start_at)->format('Y-m-d\TH:i'));
    $endValue = old('end_at', optional($ad->end_at)->format('Y-m-d\TH:i'));

    // selected geo values for preload
    $selCountry = old('country', $ad->country ?? 'India');
    $selState   = old('state',   $ad->state   ?? '');
    $selCity    = old('city',    $ad->city    ?? '');
    $selZone    = old('zone',    $ad->zone    ?? '');
    $selArea    = old('area',    $ad->area    ?? '');
    $selSociety = old('society', $ad->society ?? '');
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Title *</label>
        <input type="text" name="title" value="{{ old('title', $ad->title) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Image {{ $ad->exists ? '(leave empty to keep)' : '*' }}</label>
        <input type="file" name="image" class="form-control" @if (!$ad->exists) required @endif accept="image/*">
        @if ($ad->image_path)
            <small class="text-muted d-block mt-1">Current: {{ $ad->image_path }}</small>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label">Click URL</label>
        <input type="url" name="click_url" value="{{ old('click_url', $ad->click_url) }}" class="form-control" placeholder="https://...">
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
                $sel = collect(old('weekdays', $ad->weekdays ?? []))->map(fn($v) => strtolower($v))->all();
            @endphp
            @foreach ($weekdayOptions as $wd)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="wd_{{ $wd }}" name="weekdays[]" value="{{ $wd }}" {{ in_array($wd, $sel) ? 'checked' : '' }}>
                    <label class="form-check-label" for="wd_{{ $wd }}">{{ strtoupper($wd) }}</label>
                </div>
            @endforeach
            <small class="text-muted d-block">Keep empty = all days</small>
        </div>
    </div>

    <div class="col-md-2">
        <label class="form-label">Priority</label>
        <input type="number" name="priority" value="{{ old('priority', $ad->priority ?? 5) }}" class="form-control" min="1" max="1000">
    </div>
    <div class="col-md-5">
        <label class="form-label">Max impressions</label>
        <input type="number" name="max_impressions" value="{{ old('max_impressions', $ad->max_impressions) }}" class="form-control" min="1">
    </div>
    <div class="col-md-5">
        <label class="form-label">Max clicks</label>
        <input type="number" name="max_clicks" value="{{ old('max_clicks', $ad->max_clicks) }}" class="form-control" min="1">
    </div>

    <div class="col-md-12">
        <hr>
    </div>

    <!-- Cascading geo fields: Country -> State -> City -> Zone(add) -> Area(add) -> Society(text) -->
    <div class="col-md-4">
        <label class="form-label">Country</label>
        <select id="country" name="country" class="form-select">
            <option value="">-- Select Country --</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">State</label>
        <select id="state" name="state" class="form-select">
            <option value="">-- Select State --</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">City</label>
        <select id="city" name="city" class="form-select">
            <option value="">-- Select City --</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Zone</label>
        <div class="d-flex">
            <select id="zone" name="zone" class="form-select">
                <option value="">-- Select Zone --</option>
            </select>
            <input id="newZoneInput" type="text" class="form-control ms-2" placeholder="Add zone (if not listed)">
            <button id="addZoneBtn" type="button" class="btn btn-outline-primary ms-2">Add</button>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Area</label>
        <div class="d-flex">
            <select id="area" name="area" class="form-select">
                <option value="">-- Select Area --</option>
            </select>
            <input id="newAreaInput" type="text" class="form-control ms-2" placeholder="Add area (if not listed)">
            <button id="addAreaBtn" type="button" class="btn btn-outline-primary ms-2">Add</button>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">Society</label>
        <input type="text" name="society" value="{{ $selSociety }}" class="form-control" placeholder="Society (optional)">
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
{{-- 
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // simple country list (edit as needed)
  const countries = [
    "Brazil","Kenya","Spain","Japan","Nigeria","France","India","Australia","South Korea",
    "Argentina","Germany","Canada","Chile","Egypt","Morocco","Thailand","Italy","Mexico",
    "Russia","Netherlands","South Africa","Sweden","Saudi Arabia","Peru","Vietnam","Greece",
    "Poland","Pakistan","Belgium","Colombia","Israel","Ecuador","Malaysia","Cuba","Zimbabwe",
    "Sudan","Uruguay","Turkey","Sri Lanka"
  ];

  // DOM refs
  const countrySel = document.getElementById('country');
  const stateSel   = document.getElementById('state');
  const citySel    = document.getElementById('city');
  const zoneSel    = document.getElementById('zone');
  const areaSel    = document.getElementById('area');
  const addZoneBtn = document.getElementById('addZoneBtn');
  const newZoneInput = document.getElementById('newZoneInput');
  const addAreaBtn = document.getElementById('addAreaBtn');
  const newAreaInput = document.getElementById('newAreaInput');

  // initial values from server
  const initial = {
    country: "{{ $selCountry }}",
    state:   "{{ $selState }}",
    city:    "{{ $selCity }}",
    zone:    "{{ $selZone }}",
    area:    "{{ $selArea }}"
  };

  function reset(sel, label) {
    sel.innerHTML = `<option value="">-- Select ${label} --</option>`;
  }
  function fill(sel, arr, selected='') {
    const label = sel.name.charAt(0).toUpperCase() + sel.name.slice(1);
    reset(sel, label);
    arr.forEach(v => {
      const o = document.createElement('option'); o.value = v; o.text = v;
      if (v === selected) o.selected = true;
      sel.appendChild(o);
    });
  }

  function populateCountries() {
    countrySel.innerHTML = '<option value="">-- Select Country --</option>';
    countries.forEach(c => {
      const o = new Option(c, c);
      if (c === initial.country) o.selected = true;
      countrySel.appendChild(o);
    });
  }

  // fetch states for a country (countriesnow.space)
  async function fetchStates(country) {
    reset(stateSel,'State'); reset(citySel,'City'); reset(zoneSel,'Zone'); reset(areaSel,'Area');
    if (!country) return;
    try {
      const res = await fetch('https://countriesnow.space/api/v0.1/countries/states', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ country })
      });
      const json = await res.json();
      let states = [];
      if (json?.data?.states) states = json.data.states.map(s => typeof s === 'string' ? s : s.name);
      fill(stateSel, states, initial.state);
    } catch (e) {
      console.error('fetchStates', e);
    }
  }

  // fetch cities for a state
  async function fetchCities(country, state) {
    reset(citySel,'City'); reset(zoneSel,'Zone'); reset(areaSel,'Area');
    if (!country || !state) return;
    try {
      const res = await fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ country, state })
      });
      const json = await res.json();
      if (json?.data) fill(citySel, json.data, initial.city);
    } catch (e) {
      console.error('fetchCities', e);
    }
  }

  // events
  countrySel.addEventListener('change', () => fetchStates(countrySel.value));
  stateSel.addEventListener('change', () => fetchCities(countrySel.value, stateSel.value));

  citySel.addEventListener('change', () => {
    // zone/area left for manual add or optional local mapping
    reset(zoneSel, 'Zone'); reset(areaSel, 'Area');
  });

  zoneSel.addEventListener('change', () => {
    reset(areaSel, 'Area');
  });

  addZoneBtn.addEventListener('click', () => {
    const v = newZoneInput.value.trim(); if (!v) return;
    if (![...zoneSel.options].some(o => o.value === v)) zoneSel.appendChild(new Option(v, v));
    zoneSel.value = v; newZoneInput.value = ''; reset(areaSel, 'Area');
  });

  addAreaBtn.addEventListener('click', () => {
    const v = newAreaInput.value.trim(); if (!v) return;
    if (![...areaSel.options].some(o => o.value === v)) areaSel.appendChild(new Option(v, v));
    areaSel.value = v; newAreaInput.value = '';
  });

  // initial load + preload saved values (edit)
  populateCountries();

  (async function preload() {
    if (initial.country) {
      await fetchStates(initial.country);
      if (initial.state) {
        stateSel.value = initial.state;
        await fetchCities(initial.country, initial.state);
        if (initial.city) citySel.value = initial.city;
        if (initial.zone) {
          if (![...zoneSel.options].some(o => o.value === initial.zone)) zoneSel.appendChild(new Option(initial.zone, initial.zone));
          zoneSel.value = initial.zone;
        }
        if (initial.area) {
          if (![...areaSel.options].some(o => o.value === initial.area)) areaSel.appendChild(new Option(initial.area, initial.area));
          areaSel.value = initial.area;
        }
      }
    } else {
      // default to India if present
      if ([...countrySel.options].some(o => o.value === 'India')) countrySel.value = 'India';
    }
  })();
});
</script>
@endpush --}}
