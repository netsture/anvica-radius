<?php

namespace App\Http\Controllers;

use App\Models\RouterStatus;
use Illuminate\Http\Request;

class RouterstatusController extends Controller
{
    public function index()
    {
        // $logs = RouterStatus::latest()->get();
        $logs = RouterStatus::whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('router_status')
                    ->groupBy('router', 'mac', 'model', 'serial');
            })
            ->orderByDesc('id')
            ->get();

        return view('router-status.index', compact('logs'));
    }

    public function logs()
    {
        $logs = RouterStatus::latest()->get();
        return view('router-status.logs', compact('logs'));
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
            'model'      => $request->model,
            'serial'      => $request->serial,
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
