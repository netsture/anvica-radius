<!-- resources/views/advertisements/create.blade.php -->
@extends('layouts.app')
@section('title', 'Create Advertisement')

@section('content')

    <div class="page-content">
        <div class="main-content d-flex justify-content-between flex-wrap">
            <h3 class="page-title">Create Advertisements</h3>
            <div>
                <a href="{{ route('advertisements.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('advertisements.store') }}" method="post" class="forms-sample"
                            enctype="multipart/form-data">
                            @csrf
                            @include('advertisements._form', ['ad' => $ad])
                            {{-- paste this right after @include('advertisements._form', ['ad' => $ad]) in create.blade.php --}}
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // large countries list
                                    const countries = [
                                        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina",
                                        "Armenia", "Australia",
                                        "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
                                        "Belize", "Benin",
                                        "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria",
                                        "Burkina Faso", "Burundi",
                                        "Cambodia", "Cameroon", "Canada", "Cape Verde", "Central African Republic", "Chad", "Chile",
                                        "China", "Colombia",
                                        "Comoros", "Congo (Brazzaville)", "Congo (Kinshasa)", "Costa Rica", "Côte d'Ivoire", "Croatia",
                                        "Cuba", "Cyprus",
                                        "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt",
                                        "El Salvador", "Equatorial Guinea",
                                        "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia",
                                        "Georgia", "Germany", "Ghana",
                                        "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras",
                                        "Hungary", "Iceland", "India",
                                        "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan",
                                        "Kazakhstan", "Kenya", "Kiribati",
                                        "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya",
                                        "Liechtenstein", "Lithuania",
                                        "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta",
                                        "Marshall Islands", "Mauritania", "Mauritius",
                                        "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
                                        "Myanmar", "Namibia", "Nauru",
                                        "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea",
                                        "North Macedonia", "Norway", "Oman",
                                        "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland",
                                        "Portugal", "Qatar", "Romania",
                                        "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines",
                                        "Samoa", "San Marino",
                                        "São Tomé and Príncipe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone",
                                        "Singapore", "Slovakia",
                                        "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain",
                                        "Sri Lanka", "Sudan", "Suriname",
                                        "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo",
                                        "Tonga", "Trinidad and Tobago",
                                        "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates",
                                        "United Kingdom", "United States",
                                        "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen", "Zambia",
                                        "Zimbabwe"
                                    ];

                                    // small offline mapping (extend as needed)
                                    const localGeo = {
                                        "India": {
                                            "Andhra Pradesh": ["Visakhapatnam", "Vijayawada", "Guntur", "Tirupati"],
                                            "Arunachal Pradesh": ["Itanagar", "Tawang", "Ziro", "Pasighat"],
                                            "Assam": ["Guwahati", "Dibrugarh", "Silchar", "Tezpur"],
                                            "Bihar": ["Patna", "Gaya", "Bhagalpur", "Muzaffarpur"],
                                            "Chhattisgarh": ["Raipur", "Bhilai", "Bilaspur", "Korba"],
                                            "Goa": ["Panaji", "Margao", "Vasco da Gama", "Mapusa"],
                                            "Gujarat": [
                                                "Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", "Bhavnagar",
                                                "Botad", "Chhota Udaipur",
                                                "Dahod", "Dang", "Devbhoomi Dwarka", "Gandhinagar", "Gir Somnath", "Jamnagar",
                                                "Junagadh", "Kheda", "Kutch",
                                                "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", "Patan",
                                                "Porbandar", "Rajkot",
                                                "Sabarkantha", "Surat", "Surendranagar", "Tapi", "Vadodara", "Valsad", "Vav-Tharad"
                                            ],
                                            "Haryana": ["Gurugram", "Faridabad", "Panipat", "Ambala"],
                                            "Himachal Pradesh": ["Shimla", "Manali", "Dharamshala", "Mandi"],
                                            "Jharkhand": ["Ranchi", "Jamshedpur", "Dhanbad", "Bokaro"],
                                            "Karnataka": ["Bengaluru", "Mysuru", "Mangalore", "Hubballi"],
                                            "Kerala": ["Thiruvananthapuram", "Kochi", "Kozhikode", "Thrissur"],
                                            "Madhya Pradesh": ["Bhopal", "Indore", "Gwalior", "Jabalpur"],
                                            "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Nashik"],
                                            "Manipur": ["Imphal", "Churachandpur", "Thoubal", "Ukhrul"],
                                            "Meghalaya": ["Shillong", "Tura", "Jowai", "Nongpoh"],
                                            "Mizoram": ["Aizawl", "Lunglei", "Saiha", "Champhai"],
                                            "Nagaland": ["Kohima", "Dimapur", "Mokokchung", "Tuensang"],
                                            "Odisha": ["Bhubaneswar", "Cuttack", "Rourkela", "Puri"],
                                            "Punjab": ["Amritsar", "Ludhiana", "Jalandhar", "Patiala"],
                                            "Rajasthan": ["Jaipur", "Jodhpur", "Udaipur", "Kota"],
                                            "Sikkim": ["Gangtok", "Namchi", "Gyalshing", "Mangan"],
                                            "Tamil Nadu": ["Chennai", "Coimbatore", "Madurai", "Tiruchirappalli"],
                                            "Telangana": ["Hyderabad", "Warangal", "Nizamabad", "Khammam"],
                                            "Tripura": ["Agartala", "Udaipur", "Dharmanagar", "Kailashahar"],
                                            "Uttar Pradesh": ["Lucknow", "Kanpur", "Varanasi", "Agra"],
                                            "Uttarakhand": ["Dehradun", "Haridwar", "Rishikesh", "Nainital"],
                                            "West Bengal": ["Kolkata", "Howrah", "Durgapur", "Siliguri"],
                                            "Delhi": ["New Delhi", "Dwarka", "Rohini", "Saket"] // Union Territory


                                        },
                                        "USA": {
                                            "California": ["Los Angeles", "San Francisco", "San Diego"],
                                            "Texas": ["Houston", "Dallas", "Austin"],
                                            "Florida": ["Miami", "Orlando"]
                                        },
                                        "United Kingdom": {
                                            "England": ["London", "Manchester", "Birmingham"],
                                            "Scotland": ["Edinburgh", "Glasgow"]
                                        }
                                    };

                                    // DOM refs
                                    const countrySel = document.getElementById('country');
                                    const stateSel = document.getElementById('state');
                                    const citySel = document.getElementById('city');
                                    const zoneSel = document.getElementById('zone');
                                    const areaSel = document.getElementById('area');

                                    if (!countrySel) {
                                        console.error('country select not found (id=country)');
                                        return;
                                    }

                                    // Get initial values safely from Blade using json_encode
                                    const initial = {!! json_encode([
                                        'country' => old('country', $ad->country ?? ''),
                                        'state' => old('state', $ad->state ?? ''),
                                        'city' => old('city', $ad->city ?? ''),
                                        'zone' => old('zone', $ad->zone ?? ''),
                                        'area' => old('area', $ad->area ?? ''),
                                    ]) !!};

                                    function reset(sel, label) {
                                        if (!sel) return;
                                        sel.innerHTML = `<option value="">-- Select ${label} --</option>`;
                                    }

                                    function fill(sel, arr, selected = '') {
                                        if (!sel) return;
                                        reset(sel, sel.name ? sel.name.charAt(0).toUpperCase() + sel.name.slice(1) : 'value');
                                        arr.forEach(v => {
                                            const o = document.createElement('option');
                                            o.value = v;
                                            o.text = v;
                                            if (String(v) === String(selected)) o.selected = true;
                                            sel.appendChild(o);
                                        });
                                    }

                                    // populate countries
                                    (function populateCountries() {
                                        reset(countrySel, 'Country');
                                        countries.forEach(c => countrySel.appendChild(new Option(c, c)));
                                        if (initial.country && [...countrySel.options].some(o => o.value === initial.country))
                                            countrySel.value = initial.country;
                                        else if ([...countrySel.options].some(o => o.value === 'India')) countrySel.value = 'India';
                                    })();

                                    // Remote fallback (countriesnow.space) - optional, may be blocked by CORS
                                    async function fetchStatesRemote(countryName) {
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
                                            if (json?.data?.states) {
                                                const states = json.data.states.map(s => typeof s === 'string' ? s : s.name);
                                                fill(stateSel, states, initial.state);
                                            }
                                        } catch (e) {
                                            console.warn('Remote states fetch failed', e);
                                        }
                                    }
                                    async function fetchCitiesRemote(countryName, stateName) {
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
                                            if (json?.data) fill(citySel, json.data, initial.city);
                                        } catch (e) {
                                            console.warn('Remote cities fetch failed', e);
                                        }
                                    }

                                    // onchange handlers
                                    countrySel.addEventListener('change', function() {
                                        const c = this.value;
                                        reset(stateSel, 'State');
                                        reset(citySel, 'City');
                                        reset(zoneSel, 'Zone');
                                        reset(areaSel, 'Area');
                                        if (!c) return;
                                        if (localGeo[c]) fill(stateSel, Object.keys(localGeo[c]), initial.state);
                                        else fetchStatesRemote(c);
                                    });

                                    stateSel.addEventListener('change', function() {
                                        const c = countrySel.value,
                                            s = this.value;
                                        reset(citySel, 'City');
                                        reset(zoneSel, 'Zone');
                                        reset(areaSel, 'Area');
                                        if (!c || !s) return;
                                        if (localGeo[c] && localGeo[c][s]) fill(citySel, localGeo[c][s], initial.city);
                                        else fetchCitiesRemote(c, s);
                                    });

                                    // Zone / Area add buttons
                                    document.getElementById('addZoneBtn')?.addEventListener('click', function() {
                                        const v = (document.getElementById('newZoneInput')?.value || '').trim();
                                        if (!v) return;
                                        if (![...zoneSel.options].some(o => o.value === v)) zoneSel.appendChild(new Option(v, v));
                                        zoneSel.value = v;
                                        document.getElementById('newZoneInput').value = '';
                                        reset(areaSel, 'Area');
                                    });
                                    document.getElementById('addAreaBtn')?.addEventListener('click', function() {
                                        const v = (document.getElementById('newAreaInput')?.value || '').trim();
                                        if (!v) return;
                                        if (![...areaSel.options].some(o => o.value === v)) areaSel.appendChild(new Option(v, v));
                                        areaSel.value = v;
                                        document.getElementById('newAreaInput').value = '';
                                    });

                                    // preload (edit mode)
                                    (async function preload() {
                                        if (initial.country && [...countrySel.options].some(o => o.value === initial.country)) {
                                            countrySel.value = initial.country;
                                            countrySel.dispatchEvent(new Event('change'));
                                            if (!localGeo[initial.country]) await fetchStatesRemote(initial.country);
                                            if (initial.state && [...stateSel.options].some(o => o.value === initial.state)) {
                                                stateSel.value = initial.state;
                                                stateSel.dispatchEvent(new Event('change'));
                                                if (!localGeo[initial.country] || !localGeo[initial.country][initial.state]) {
                                                    await fetchCitiesRemote(initial.country, initial.state);
                                                }
                                            }
                                        } else {
                                            if ([...countrySel.options].some(o => o.value === 'India')) {
                                                countrySel.value = 'India';
                                                countrySel.dispatchEvent(new Event('change'));
                                            }
                                        }

                                        if (initial.zone && ![...zoneSel.options].some(o => o.value === initial.zone)) zoneSel
                                            .appendChild(new Option(initial.zone, initial.zone));
                                        if (initial.area && ![...areaSel.options].some(o => o.value === initial.area)) areaSel
                                            .appendChild(new Option(initial.area, initial.area));
                                        if (initial.zone) zoneSel.value = initial.zone;
                                        if (initial.area) areaSel.value = initial.area;
                                    })();

                                });
                            </script>

                            <button class="btn btn-primary me-2">Save</button>
                            <a href="{{ route('advertisements.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
