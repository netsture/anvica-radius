<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdvertisementApiController extends Controller
{
    /**
     * GET /api/advertisements
     *
     * Query params:
     * - q            => search title
     * - start_date   => YYYY-MM-DD (filter ads active on/after this date)
     * - end_date     => YYYY-MM-DD (filter ads active on/before this date)
     * - time_slot    => all|morning|afternoon|evening|night
     * - weekday      => mon|tue|wed|thu|fri|sat|sun
     * - status       => draft|active|paused|expired
     * - per_page     => pagination size (default 20)
     */
    public function index(Request $request)
    {
        $q = Advertisement::query();

        // full-text search on title (simple)
        if ($search = $request->query('q')) {
            $q->where('title', 'like', '%' . $search . '%');
        }

        // status filter
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }

        // time_slot filter: we include ads that explicitly match OR ads set to 'all'
        if ($timeSlot = $request->query('time_slot')) {
            $q->where(function ($sub) use ($timeSlot) {
                $sub->where('time_slot', $timeSlot)
                    ->orWhere('time_slot', 'all');
            });
        }

        // weekday filter: include ads whose weekdays is null (meaning all days) OR contains requested weekday
        if ($weekday = $request->query('weekday')) {
            $weekday = strtolower($weekday);
            $q->where(function ($sub) use ($weekday) {
                $sub->whereNull('weekdays')
                    ->orWhereJsonContains('weekdays', $weekday);
            });
        }

        // date-range overlap filtering:
        // If start_date and/or end_date provided, we return ads whose [start_at, end_at] interval overlaps with given interval.
        // Treat null start_at as -infinity and null end_at as +infinity.
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate || $endDate) {
            // if only one provided, treat the other as same day
            if (! $startDate) $startDate = $endDate;
            if (! $endDate) $endDate = $startDate;

            // make sure times are end-of-day / start-of-day for safe overlap (user gives YYYY-MM-DD)
            try {
                $start = \Carbon\Carbon::parse($startDate)->startOfDay();
                $end = \Carbon\Carbon::parse($endDate)->endOfDay();
            } catch (\Exception $e) {
                return response()->json(['message' => 'Invalid date format. Use YYYY-MM-DD.'], 422);
            }

            // Interval overlap:
            // WHERE (start_at IS NULL OR start_at <= $end) AND (end_at IS NULL OR end_at >= $start)
            $q->where(function ($sub) use ($start, $end) {
                $sub->where(function ($s) use ($end) {
                        $s->whereNull('start_at')
                          ->orWhere('start_at', '<=', $end);
                    })
                    ->where(function ($s) use ($start) {
                        $s->whereNull('end_at')
                          ->orWhere('end_at', '>=', $start);
                    });
            });
        }

        // ordering + pagination
        $perPage = (int) $request->query('per_page', 20);
        $ads = $q->latest()->paginate($perPage)->withQueryString();

        // map results to include a stable public image URL
        $ads->getCollection()->transform(function (Advertisement $ad) {
            // resolve image url:
            $imageUrl = null;
            if (!empty($ad->image_path)) {
                // if file exists on public disk (storage/app/public/...), use disk url
                if (Storage::disk('public')->exists($ad->image_path)) {
                    $imageUrl = Storage::disk('public')->url($ad->image_path);
                } else {
                    // fallback: if it's already a public path like "ads/..." stored under public/
                    // asset() can resolve it
                    // ensure path is not absolute URL
                    if (Str::startsWith($ad->image_path, ['http://','https://'])) {
                        $imageUrl = $ad->image_path;
                    } else {
                        $imageUrl = asset($ad->image_path);
                    }
                }
            }

            return [
                'id'             => $ad->id,
                'title'          => $ad->title,
                'click_url'      => $ad->click_url,
                'start_at'       => optional($ad->start_at)->toDateTimeString(),
                'end_at'         => optional($ad->end_at)->toDateTimeString(),
                'time_slot'      => $ad->time_slot,
                'weekdays'       => $ad->weekdays, // array or null
                'priority'       => $ad->priority,
                'max_impressions'=> $ad->max_impressions,
                'max_clicks'     => $ad->max_clicks,
                'country'        => $ad->country,
                'state'          => $ad->state,
                'city'           => $ad->city,
                'zone'           => $ad->zone,
                'area'           => $ad->area,
                'society'        => $ad->society,
                'status'         => $ad->status,
                'image_url'      => $imageUrl,
            ];
        });

        return response()->json($ads);
    }
}
