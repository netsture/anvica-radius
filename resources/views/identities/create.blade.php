@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">Create Identity</h3>
            <div>
                <a href="{{ route('identities.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form id="identityForm" action="{{ route('identities.store') }}" method="post" class="forms-sample">
                            @csrf

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>MAC Address</label>
                                    <input type="text" id="mac" name="mac" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Model</label>
                                    <input type="text" id="model" name="model" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Serial</label>
                                    <input type="text" id="serial" name="serial" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Country</label>
                                    <select id="country" name="country" class="form-select" required>
                                        <option value="">-- Select Country --</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>State</label>
                                    <select id="state" name="state" class="form-select" required>
                                        <option value="">-- Select State --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>City</label>
                                    <select id="city" name="city" class="form-select" required>
                                        <option value="">-- Select City --</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Zone</label>
                                    <div class="d-flex">
                                        <select id="zone" name="zone" class="form-select" required>
                                            <option value="">-- Select Zone --</option>
                                        </select>
                                        <input id="newZoneInput" type="text" class="form-control me-2"
                                            placeholder="Add zone">
                                        <button id="addZoneBtn" type="button" class="btn btn-outline-primary">Add</button>
                                    </div>
                                    <small class="text-muted">You can select existing zone or add new</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Area</label>
                                <div class="d-flex">
                                    <select id="area" name="area" class="form-select" required>
                                        <option value="">-- Select Area --</option>
                                    </select>
                                    <input id="newAreaInput" type="text" class="form-control me-2"
                                        placeholder="Add area">
                                    <button id="addAreaBtn" type="button" class="btn btn-outline-primary">Add</button>
                                </div>
                                <small class="text-muted">Add area based on selected zone (or choose existing)</small>
                            </div>

                            <div class="mb-3">
                                <label>Society</label>
                                <select name="society" class="form-select">
                                    <option value="super premium">Super Premium</option>
                                    <option value="premium">Premium</option>
                                    <option value="standard">Standard</option>
                                    <option value="standard">Middle Class</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>OTP Options</label><br>
                                <div class="form-check form-check-inline">
                                    <input id="otp_sms" class="form-check-input" type="checkbox" name="otp_sms"
                                        value="1">
                                    <label class="form-check-label" for="otp_sms">SMS</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="otp_whatsapp" class="form-check-input" type="checkbox" name="otp_whatsapp"
                                        value="1" checked>
                                    <label class="form-check-label" for="otp_whatsapp">WhatsApp</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="otp_email" class="form-check-input" type="checkbox" name="otp_email"
                                        value="1">
                                    <label class="form-check-label" for="otp_email">Email</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('identities.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // country list you asked for
            const countries = [
                "Brazil", "Kenya", "Spain", "Japan", "Nigeria", "France", "India", "Australia", "South Korea",
                "Argentina", "Germany", "Canada", "Chile", "Egypt", "Morocco", "Thailand", "Italy", "Mexico",
                "Russia", "Netherlands", "South Africa", "Sweden", "Saudi Arabia", "Peru", "Vietnam", "Greece",
                "Poland", "Pakistan", "Belgium", "Colombia", "Israel", "Ecuador", "Malaysia", "Cuba",
                "Zimbabwe",
                "Sudan", "Uruguay", "Turkey", "Sri Lanka"
            ];


            // DOM refs
            const countrySel = document.getElementById('country');
            const stateSel = document.getElementById('state');
            const citySel = document.getElementById('city');
            const zoneSel = document.getElementById('zone');
            const areaSel = document.getElementById('area');
            const addZoneBtn = document.getElementById('addZoneBtn');
            const newZoneInput = document.getElementById('newZoneInput');
            const addAreaBtn = document.getElementById('addAreaBtn');
            const newAreaInput = document.getElementById('newAreaInput');

            // populate countries dropdown
            function populateCountries() {
                countrySel.innerHTML = '<option value="">-- Select Country --</option>';
                countries.forEach(c => {
                    const o = document.createElement('option');
                    o.value = c;
                    o.text = c;
                    if (c === 'India') o.selected = true;
                    countrySel.appendChild(o);
                });
            }

            function reset(sel, label) {
                sel.innerHTML = `<option value="">-- Select ${label} --</option>`;
            }

            function fill(sel, arr) {
                reset(sel, sel.name.charAt(0).toUpperCase() + sel.name.slice(1));
                arr.forEach(v => sel.appendChild(new Option(v, v)));
            }

            // fetch states (countriesnow.space) - same as before
            async function fetchStates(countryName) {
                reset(stateSel, 'State');
                reset(citySel, 'City');
                reset(zoneSel, 'Zone');
                reset(areaSel, 'Area');
                if (!countryName) return;
                try {
                    const res = await fetch('https://countriesnow.space/api/v0.1/countries/states', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            country: countryName
                        })
                    });
                    const json = await res.json();
                    if (!json.data || !json.data.states) return;
                    const states = json.data.states.map(s => (typeof s === 'string') ? s : s.name);
                    fill(stateSel, states);
                } catch (e) {
                    console.error('fetchStates error', e);
                }
            }

            // fetch cities
            async function fetchCities(countryName, stateName) {
                reset(citySel, 'City');
                reset(zoneSel, 'Zone');
                reset(areaSel, 'Area');
                if (!countryName || !stateName) return;
                try {
                    const res = await fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            country: countryName,
                            state: stateName
                        })
                    });
                    const json = await res.json();
                    if (!json.data) return;
                    fill(citySel, json.data);
                } catch (e) {
                    console.error('fetchCities error', e);
                }
            }

            // Populate zones automatically from zoneAreaData if available
            function populateZonesFromData(country, state, city) {
                reset(zoneSel, 'Zone');
                reset(areaSel, 'Area');
                try {
                    const zonesObj = zoneAreaData?.[country]?.[state]?.[city];
                    if (!zonesObj) return false; // no mapping available
                    const zones = Object.keys(zonesObj);
                    fill(zoneSel, zones);
                    return true;
                } catch (e) {
                    console.error('populateZonesFromData', e);
                    return false;
                }
            }

            // Populate areas for selected zone from zoneAreaData
            function populateAreasFromData(country, state, city, zone) {
                reset(areaSel, 'Area');
                try {
                    const areas = zoneAreaData?.[country]?.[state]?.[city]?.[zone] || [];
                    if (areas.length) fill(areaSel, areas);
                    return areas.length > 0;
                } catch (e) {
                    console.error('populateAreasFromData', e);
                    return false;
                }
            }

            // Event listeners
            countrySel.addEventListener('change', () => {
                fetchStates(countrySel.value);
            });

            stateSel.addEventListener('change', () => {
                fetchCities(countrySel.value, stateSel.value);
            });

            citySel.addEventListener('change', () => {
                // first try to populate zones from our zoneAreaData
                const ok = populateZonesFromData(countrySel.value, stateSel.value, citySel.value);
                if (!ok) {
                    // if no mapping, keep zone dropdown empty but allow user to add
                    reset(zoneSel, 'Zone');
                    reset(areaSel, 'Area');
                    // optionally, you could call a sampleZonesForCity fallback here if you want
                } else {
                    // if zones populated, automatically select first zone and populate areas
                    zoneSel.selectedIndex = 1; // choose first real option (index 0 is placeholder)
                    const chosen = zoneSel.value;
                    if (chosen) populateAreasFromData(countrySel.value, stateSel.value, citySel.value,
                        chosen);
                }
            });

            zoneSel.addEventListener('change', () => {
                const ok = populateAreasFromData(countrySel.value, stateSel.value, citySel.value, zoneSel
                    .value);
                if (!ok) {
                    reset(areaSel, 'Area'); // allow user to add areas manually
                }
            });

            // Add zone button: user can still add custom zone
            if (addZoneBtn) addZoneBtn.addEventListener('click', () => {
                const v = newZoneInput.value.trim();
                if (!v) return;
                if (![...zoneSel.options].some(o => o.value === v)) zoneSel.appendChild(new Option(v, v));
                zoneSel.value = v;
                newZoneInput.value = '';
                reset(areaSel, 'Area');
            });

            // Add area button
            if (addAreaBtn) addAreaBtn.addEventListener('click', () => {
                const v = newAreaInput.value.trim();
                if (!v) return;
                if (![...areaSel.options].some(o => o.value === v)) areaSel.appendChild(new Option(v, v));
                areaSel.value = v;
                newAreaInput.value = '';
            });

            // initial load
            populateCountries();
            if (countrySel.value) fetchStates(countrySel.value);
        });
    </script>
@endsection
