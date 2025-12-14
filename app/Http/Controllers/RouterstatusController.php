<?php

namespace App\Http\Controllers;

use App\Models\RouterStatus;
use Illuminate\Http\Request;

class RouterstatusController extends Controller
{
    public function index()
    {
        $logs = RouterStatus::latest()->paginate(20);

        return view('router-status.index', compact('logs'));
    }

    public function store(Request $request)
    {
        // Basic validation
        if (!$request->router || !$request->status) {
            return response('Invalid data...', 400);
        }

        RouterStatus::create([
            'router'      => $request->router,
            'status'      => strtoupper($request->status),
            'event_date'  => $request->date ?? '2025-12-12',
            'event_time'  => $request->time ?? '12:00:00',
            'ip_address'  => $request->ip(),
        ]);

        // MikroTik expects plain response
        return response('Status Updated Successfully', 200);
    }
}
