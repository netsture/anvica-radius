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
        // dd($request->all());
        RouterStatus::create([
            'router'      => $request->router,
            'status'      => strtoupper($request->status),
            'mac'      => $request->mac,
            'event_datetime'  => $request->date ?? date('Y-m-d H:i:s'),
            'ip_address'  => $request->ip(),
            'api_request'  => json_encode([
                'headers' => $request->headers->all(),
                'body'    => $request->all(),
                'method'  => $request->method(),
                'url'     => $request->fullUrl(),
            ]),
        ]);

        // MikroTik expects plain response
        return response('Status Updated Successfully', 200);
    }
}
