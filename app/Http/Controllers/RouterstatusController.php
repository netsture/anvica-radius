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
            'event_date'  => $request->date ?? now()->toDateString(),
            'event_time'  => $request->time ?? now()->toTimeString(),
            'ip_address'  => $request->ip(),
        ]);

        // MikroTik expects plain response
        return response('Status Updated Successfully', 200);
    }
}
