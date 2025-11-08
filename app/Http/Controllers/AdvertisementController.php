<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUpdateAdvertisementRequest;

class AdvertisementController extends Controller
{
    private array $status = ['draft','active','paused','expired'];
    private array $slots  = ['all','morning','afternoon','evening','night'];
    private array $weekdays = ['mon','tue','wed','thu','fri','sat','sun'];

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
            'statusOptions' => $this->status,
        ]);
    }

    public function create()
    {
        return view('advertisements.create', [
            'statusOptions' => $this->status,
            'slotOptions'   => $this->slots,
            'weekdayOptions'=> $this->weekdays,
            'ad' => new Advertisement(),
        ]);
    }

    public function store(StoreUpdateAdvertisementRequest $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ads', 'public'); // ads/<file>
        }

        $data['created_by'] = auth()->id();

        $ad = Advertisement::create($data);

        return redirect()->route('advertisements.edit', $ad)
            ->with('success','Advertisement created.');
    }

    public function show(Advertisement $advertisement)
    {
        return view('advertisements.show', ['ad' => $advertisement]);
    }

    public function edit(Advertisement $advertisement)
    {
        return view('advertisements.edit', [
            'ad' => $advertisement,
            'statusOptions' => $this->status,
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
