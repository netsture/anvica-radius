<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
    public function getVideo(Request $request)
    {
        $q = Advertisement::query();
        $q->where('page_section', 'page1_video');

        $ad = $q->inRandomOrder()->first();

        if (!$ad) {
            return response()->json([
                'status' => false,
                'message' => 'No advertisement found',
            ], 404);
        }

        $mediaUrl = null;
        if (!empty($ad->media_path)) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($ad->media_path)) {
                $mediaUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($ad->media_path);
            } elseif (\Illuminate\Support\Str::startsWith($ad->media_path, ['http://','https://'])) {
                $mediaUrl = $ad->media_path;
            } else {
                $mediaUrl = env('APP_URL') . "/public/" . $ad->media_path;
            }
        }

        /*AdvertisementLog::create([
            'advertisement_id'  => $ad->id,
            'event'      => 'view',
            'ip'         => $request->ip(),
            'user_agent' => substr($request->userAgent(),0,255),
            'created_at' => Carbon::now()
        ]);*/

        return response()->json([
            'status' => true,
            'data' => [
                'id'        => $ad->id,
                'title'     => $ad->title,
                'click_url' => $ad->click_url ?? 'https://www.anvica.in',
                'status'    => $ad->status,
                'image_url' => $mediaUrl,
            ]
        ]);
    }

    public function getImage(Request $request)
    {
        $pageSection = $request->query('page_section');
        $ad = Advertisement::where('page_section', $pageSection)->inRandomOrder()->first();

        if (!$ad) {
            $ad = Advertisement::where('media_type', 'image')->inRandomOrder()->first();
        }
        if (!$ad) {
            return response()->json([
                'status' => false,
                'message' => 'No advertisement found',
            ], 404);
        }

        $mediaUrl = null;
        if (!empty($ad->media_path)) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($ad->media_path)) {
                $mediaUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($ad->media_path);
            } elseif (\Illuminate\Support\Str::startsWith($ad->media_path, ['http://','https://'])) {
                $mediaUrl = $ad->media_path;
            } else {
                $mediaUrl = env('APP_URL') . "/public/" . $ad->media_path;
            }
        }

        /*AdvertisementLog::create([
            'advertisement_id'  => $ad->id,
            'event'      => 'view',
            'ip'         => $request->ip(),
            'user_agent' => substr($request->userAgent(),0,255),
            'created_at' => Carbon::now()
        ]);*/
        
        return response()->json([
            'status' => true,
            'data' => [
                'id'        => $ad->id,
                'advertiser_id' => $ad->advertiser_id,
                'title'     => $ad->title,
                'page_section' => $ad->page_section,
                'click_url' => $ad->click_url ?? 'https://www.anvica.in',
                'status'    => $ad->status,
                'image_url' => $mediaUrl,
            ]
        ]);
    }

    public function getAdvertiseOld(Request $request)
    {
        $q = Advertisement::query();

        if ($search = $request->query('q')) {
            $q->where('title', 'like', '%' . $search . '%');
        }
        if ($status = $request->query('status')) {
            $q->where('status', $status);
        }
        if ($timeSlot = $request->query('time_slot')) {
            $q->where(function ($sub) use ($timeSlot) {
                $sub->where('time_slot', $timeSlot)
                    ->orWhere('time_slot', 'all');
            });
        }
        if ($weekday = $request->query('weekday')) {
            $weekday = strtolower($weekday);
            $q->where(function ($sub) use ($weekday) {
                $sub->whereNull('weekdays')
                    ->orWhereJsonContains('weekdays', $weekday);
            });
        }
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate || $endDate) {
            if (! $startDate) $startDate = $endDate;
            if (! $endDate) $endDate = $startDate;

            try {
                $start = \Carbon\Carbon::parse($startDate)->startOfDay();
                $end = \Carbon\Carbon::parse($endDate)->endOfDay();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Invalid date format. Use YYYY-MM-DD.'], 422);
            }

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

        // get all matched ads (no pagination)
        $adsCollection = $q->latest()->get();

        // map results to include a stable public image URL
        $data = $adsCollection->map(function (Advertisement $ad) {
            $imageUrl = null;
            if (!empty($ad->media_path)) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($ad->media_path)) {
                    $imageUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($ad->media_path);
                } else {
                    if (\Illuminate\Support\Str::startsWith($ad->media_path, ['http://','https://'])) {
                        $imageUrl = $ad->media_path;
                    } else {
                        $imageUrl = env('APP_URL')."/public/".$ad->media_path;
                    }
                }
            }
            return [
                'id'             => $ad->id,
                'title'          => $ad->title,
                'click_url'      => $ad->click_url ?? 'www.anvica.in',
                'start_at'       => optional($ad->start_at)->toDateTimeString(),
                'end_at'         => optional($ad->end_at)->toDateTimeString(),
                'time_slot'      => $ad->time_slot,
                'weekdays'       => $ad->weekdays,
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
        })->all(); // ->all() to get plain array

        return response()->json([
            'status' => true,
            'count'  => count($data),
            'data'   => $data,
        ]);
    }

    public function viewAdvertise($id, Request $r)
    {
        AdvertisementLog::create([
            'advertisement_id' => $id,
            'event' => 'view',
            'mac' => $r->mac,
            'ip' => $r->ip(),
            'user_agent' => substr($r->userAgent(), 0, 255),
            'created_at' => Carbon::now()
        ]);
        return response()->json(['status'=>'logged']);
    }

    // Log CLICK event + Redirect
    public function clickAdvertise($id, Request $r)
    {
        AdvertisementLog::create([
            'advertisement_id'  => $id,
            'event'      => 'click',
            'mac'        => $r->mac,
            'ip'         => $r->ip(),
            'user_agent' => substr($r->userAgent(),0,255),
            'created_at' => Carbon::now()
        ]);

        return redirect()->away($r->redirect ?? 'https://google.com');
    }

}
