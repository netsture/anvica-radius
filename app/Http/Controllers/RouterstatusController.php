<?php

namespace App\Http\Controllers;

use App\Models\RouterStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouterstatusController extends Controller
{
    public function index()
    {
        // $logs = RouterStatus::latest()->get();
        /*$logs = RouterStatus::whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('router_status')
                    ->groupBy('router', 'mac', 'model', 'serial');
            })
            ->orderByDesc('id')
            ->get();*/

        $logs = DB::table('router_status')
            ->select('router', 'mac', 'model', 'serial', 'ip_address',
                DB::raw('MAX(event_datetime) as last_event_time'),
                DB::raw("
                    CASE
                        WHEN MAX(event_datetime) >= NOW() - INTERVAL 30 MINUTE
                        THEN 'UP'
                        ELSE 'DOWN'
                    END as status
                ")
            )
            ->groupBy('router', 'mac', 'model', 'serial')
            ->orderByDesc('last_event_time')
            ->get();    

        return view('router-status.index', compact('logs'));
    }

    public function logs()
    {
        $logs = RouterStatus::latest()->get();
        return view('router-status.logs', compact('logs'));
    }

    /*
    * Store router status from API request
    * @param Request $request
    * @return \Illuminate\Http\Response
    * Route::post('/router-status', [RouterstatusController::class, 'store']);
    */
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
