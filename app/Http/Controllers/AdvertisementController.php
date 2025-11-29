<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUpdateAdvertisementRequest;
use App\Models\AdvertisementLog;

class AdvertisementController extends Controller
{
    private array $slots  = ['All','Morning','Afternoon','Evening','Night'];
    private array $weekdays = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

    public function redirectToUrl(Request $request)
    {
        $url = $request->query('url');          // redirect URL
        if (!$url) {
            return response("No URL Provided", 400);
        }
       
        AdvertisementLog::create([
            'advertisement_id' => $request->query('id'),
            'event' => 'click',
            'redirect_url' => $url,
            'mac' => $request->query('mac'),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent(), 0, 255),
        ]);
        
        // add https if user passes only domain
        if (!preg_match("~^(http|https)://~", $url)) {
            $url = "https://" . $url;
        }

        return redirect()->away($url);
    }

    public function logs(Request $request)
    {
        $ads = Advertisement::withCount([
            'viewLogs as view_count',
            'clickLogs as click_count'
        ])->get();

        return view('advertisements.logs', [
            'ads' => $ads,
        ]);
    }

    public function index(Request $request)
    {
        $q = Advertisement::query();

        if ($search = $request->get('q')) {
            $q->where('title','like',"%{$search}%");
        }
        if ($st = $request->get('status')) {
            $q->where('status',$st);
        }

        $ads = $q->latest()->paginate(12)->withQueryString();

        return view('advertisements.index', [
            'ads' => $ads,
        ]);
    }

    public function create()
    {
        return view('advertisements.create', [
            'slotOptions'   => $this->slots,
            'weekdayOptions'=> $this->weekdays,
            'ad' => new Advertisement(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        /* $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public'); // ads/<file>
        }
        $data['created_by'] = auth()->id();
        $ad = Advertisement::create($data);
        return redirect()->route('advertisements.edit', $ad)->with('success','Advertisement created.'); */

        // Allowed enums as per your form
        // $statusOptions  = ['draft', 'active', 'paused', 'expired'];
        // $slotOptions    = ['all', 'morning', 'afternoon', 'evening', 'night'];
        $weekdayOptions = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        // Validate input
        $validated = $request->validate([
            'title'           => ['required', 'string', 'max:255'],
            'image'           => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:3072'], // 3MB
            'click_url'       => ['nullable', 'url', 'max:2048'],
            'start_at'        => ['nullable', 'date'],
            'end_at'          => ['nullable', 'date', 'after:start_at'],
            'time_slot'       => ['required'],
            'weekdays'        => ['nullable', 'array'],
            'weekdays.*'      => ['in:' . implode(',', $weekdayOptions)],
            'priority'        => ['nullable', 'integer', 'min:1', 'max:1000'],
            'max_impressions' => ['nullable', 'integer', 'min:1'],
            'max_clicks'      => ['nullable', 'integer', 'min:1'],
            'country'         => ['nullable', 'string', 'max:100'],
            'state'           => ['nullable', 'string', 'max:100'],
            'city'            => ['nullable', 'string', 'max:100'],
            'zone'            => ['nullable', 'string', 'max:100'],
            'area'            => ['nullable', 'string', 'max:100'],
            'society'         => ['nullable', 'string', 'max:150'],
            'status'         =>  ['required'],
        ], [
            'title.required'  => 'The title field is required.',
            'image.required'  => 'Please upload an image.',
            'end_at.after'    => 'End time must be after start time.',
        ]);
        // dd($validated);
        // Handle image upload
        // $imagePath = $request->file('image')->store('ads', 'public'); // storage/app/public/ads/...
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            if (!file_exists(public_path('ads'))) {
                mkdir(public_path('ads'), 0755, true);
            }
            // Move to /public/ads directory
            $image->move(public_path('ads'), $imageName);

            // Store relative path in DB
            $imagePath = 'ads/' . $imageName;
        }
        
        // Normalize weekdays to lowercase unique array; allow empty = all days (store null)
        $weekdays = $request->input('weekdays', []);
        $weekdays = array_values(array_unique(array_map(fn($v) => strtolower($v), $weekdays)));
        if (empty($weekdays)) {
            $weekdays = null;
        }
        // dd($validated);
        // Create the advertisement
        $ad = Advertisement::create([
            'title'           => $validated['title'],
            'image_path'      => $imagePath,
            'click_url'       => $validated['click_url'] ?? null,
            'start_at'        => $validated['start_at'] ?? null,
            'end_at'          => $validated['end_at'] ?? null,
            'time_slot'       => $validated['time_slot'],
            'weekdays'        => $weekdays, // cast to json in model
            'priority'        => $validated['priority'] ?? 5,
            'max_impressions' => $validated['max_impressions'] ?? null,
            'max_clicks'      => $validated['max_clicks'] ?? null,
            'country'         => $validated['country'] ?? null,
            'state'           => $validated['state'] ?? null,
            'city'            => $validated['city'] ?? null,
            'zone'            => $validated['zone'] ?? null,
            'area'            => $validated['area'] ?? null,
            'society'         => $validated['society'] ?? null,
            'status'          => $validated['status'],
        ]);
        // dd($validated);
        return redirect()
            ->route('advertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }

    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', ['ad' => $advertisement]);
    }

    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit', [
            'ad' => $advertisement,
            // 'statusOptions' => $this->status,
            'slotOptions'   => $this->slots,
            'weekdayOptions'=> $this->weekdays,
        ]);
    }

    public function update(StoreUpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            // delete old if exists
            if ($advertisement->image_path && Storage::disk('public')->exists($advertisement->image_path)) {
                Storage::disk('public')->delete($advertisement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('ads', 'public');
        }

        $advertisement->update($data);

        return redirect()->route('advertisements.edit', $advertisement)
            ->with('success','Advertisement updated.');
    }

    public function destroy(Advertisement $advertisement)
    {
        // Delete file
        if ($advertisement->image_path && Storage::disk('public')->exists($advertisement->image_path)) {
            Storage::disk('public')->delete($advertisement->image_path);
        }
        $advertisement->delete();

        return redirect()->route('advertisements.index')
            ->with('success','Advertisement deleted.');
    }

    private function validatedData(StoreUpdateAdvertisementRequest $request): array
    {
        $data = $request->validated();

        // Normalize weekdays to array or null
        $data['weekdays'] = $data['weekdays'] ?? null;

        // Convert empty strings to null for geo fields
        foreach (['country','state','city','zone','area','society','click_url'] as $f) {
            if (isset($data[$f]) && $data[$f] === '') $data[$f] = null;
        }

        // Default priority
        if (empty($data['priority'])) $data['priority'] = 5;

        return $data;
    }
}
