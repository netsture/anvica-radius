<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUpdateAdvertisementRequest;
use App\Models\AdvertisementLog;
use App\Models\User;

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

    public function history(Request $request)
    {
        $ad_id = $request->get('ad_id');
        $event = $request->get('event', 'view');
        $datas = AdvertisementLog::where('event', $event)
                ->where('advertisement_id', $ad_id)
                ->orderBy('id', 'desc')
                ->get();
        // dd(count($datas));
        return view('advertisements.history', [
            'ad_id' => $ad_id,
            'datas' => $datas,
        ]);
    }

    public function index(Request $request)
    {
        $q = Advertisement::query();
        // dd(auth()->user()->role, auth()->id());
        if (auth()->user()->role === 'Advertiser') {        
            $q->where('advertiser_id', auth()->id());
        }

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
        if (auth()->user()->isAdmin()) {
            $advertisers = User::where('role', 'Advertiser')->orderBy('first_name')->get();
        } else {
            $advertisers = User::where('id', auth()->id())->get();
        }

        return view('advertisements.create', [
            'slotOptions' => $this->slots,
            'weekdayOptions' => $this->weekdays,
            'advertisers' => $advertisers,
            'ad' => new Advertisement(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $weekdayOptions = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        // Validate input
        $validated = $request->validate([
            'advertiser_id'   => ['required', 'exists:users,id'],
            'title'           => ['required', 'string', 'max:255'],
            'page_section'    => ['required'],
            // 'image'           => ['required', 'image', 'mimes:jpg,jpeg,png,gif,mp4,mov,webm,webp,avif', 'max:5120'], // 5MB
            'media'           => ['required', 'file', 'mimes:jpg,jpeg,png,gif,mp4,mov,webm,webp,avif', 'max:5120'], // 5MB
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
            'media.required'  => 'Please upload a media file.',
            'end_at.after'    => 'End time must be after start time.',
        ]);
        // dd($validated);

        if ($request->hasFile('media')) {
            $media      = $request->file('media');
            $mediaName  = time() . '_' . uniqid() . '.' . $media->getClientOriginalExtension();

            // $media_type = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : 'other');

            $mime = $media->getClientMimeType(); // e.g. image/jpeg or video/mp4
            $ext  = strtolower($media->getClientOriginalExtension());
            if (str_starts_with($mime, 'image/') || in_array($ext, ['jpg','jpeg','png','gif','webp','avif'])) {
                $media_type = 'image';
            } elseif (str_starts_with($mime, 'video/') || in_array($ext, ['mp4','mov','webm'])) {
                $media_type = 'video';
            } else {
                return back()->withErrors(['media' => 'Unsupported media type']);
            }

            if (!file_exists(public_path('media'))) {
                mkdir(public_path('media'), 0755, true);
            }
            // Move to /public/media directory
            $media->move(public_path('media'), $mediaName);

            // Store relative path in DB
            $media_path = 'media/' . $mediaName;
        }
        
        // Normalize weekdays to lowercase unique array; allow empty = all days (store null)
        $weekdays = $request->input('weekdays', []);
        $weekdays = array_values(array_unique(array_map(fn($v) => strtolower($v), $weekdays)));
        if (empty($weekdays)) {
            $weekdays = null;
        }

        // Create the advertisement
        $ad = Advertisement::create([
            'advertiser_id'   => $validated['advertiser_id'],
            'title'           => $validated['title'],
            'media_path'      => $media_path,
            'media_type'      => $media_type,
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
        if (auth()->user()->isAdmin()) {
            $advertisers = User::where('role', 'Advertiser')->orderBy('first_name')->get();
        } else {
            $advertisers = User::where('id', auth()->id())->get();
        }

        return view('advertisements.edit', [
            'ad' => $advertisement,            
            'slotOptions'   => $this->slots,
            'weekdayOptions'=> $this->weekdays,
            'advertisers' => $advertisers,
        ]);
    }

    public function update(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        $weekdayOptions = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

        $validated = $request->validate([
            'advertiser_id'   => ['required', 'exists:users,id'],
            'title'           => ['required', 'string', 'max:255'],
            'page_section'    => ['required'],
            'media'           => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,avif,mp4,mov,webm', 'max:51200'],
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
            'status'          => ['required'],
        ]);

        $weekdays = $request->input('weekdays', []);
        $weekdays = array_values(array_unique(array_map('strtolower', $weekdays)));
        if (empty($weekdays)) {
            $weekdays = null;
        }

        if ($request->hasFile('media')) {

            // Delete old media
            if ($advertisement->media_path && Storage::disk('public')->exists($advertisement->media_path)) {
                Storage::disk('public')->delete($advertisement->media_path);
            }

            $file = $request->file('media');
            $ext  = strtolower($file->getClientOriginalExtension());

            $media_type = in_array($ext, ['mp4', 'mov', 'webm']) ? 'video' : 'image';
            $media_path = $file->store('media', 'public');

            $advertisement->media_path = $media_path;
            $advertisement->media_type = $media_type;
        }
        // dd($advertisement);
        $advertisement->update([
            'advertiser_id'   => $validated['advertiser_id'],
            'title'           => $validated['title'],
            'page_section'    => $validated['page_section'],
            'click_url'       => $validated['click_url'] ?? null,
            'start_at'        => $validated['start_at'] ?? null,
            'end_at'          => $validated['end_at'] ?? null,
            'time_slot'       => $validated['time_slot'],
            'weekdays'        => $weekdays,
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

        return redirect()
            ->route('advertisements.index')
            ->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement)
    {
        // Delete file
        if ($advertisement->media_path && Storage::disk('public')->exists($advertisement->media_path)) {
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
