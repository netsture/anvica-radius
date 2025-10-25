<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (empty(auth()->user()->identity_id)) {
            $datas = Plan::orderBy('srvid','desc')->get();
        } else {
            $datas = Plan::where('identity_id', auth()->user()->identity_id)->orderBy('srvid','desc')->get();
        }
        return view('plans.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $identities = \DB::table('identities')->pluck('name', 'id');
        if (empty(auth()->user()->identity_id)) {
            $identities = \DB::table('identities')->pluck('name', 'id');
        } else {
            $identities = \DB::table('identities')->where('id', auth()->user()->identity_id)->pluck('name', 'id');
        }
        return view('plans.create', compact('identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'srvname'     => 'required|string|max:255',
            'descr'       => 'nullable|string',
            'downrate'    => 'required|numeric|min:0',
            'uprate'      => 'required|numeric|min:0',
        ]);
        $data = Plan::orderBy('srvid','desc')->first();
        Plan::create([
            'srvid' => $data ? $data->srvid + 1 : 1,
            'srvname' => $request->srvname,
            'descr' => $request->descr,
            'downrate' => $request->downrate,
            'uprate' => $request->uprate,
            'limitdl' => 0,
            'limitul' => 0,
            'limitcomb' => 0,
            'limitexpiration' => 0,
            'limituptime' => 0,
            'poolname' => '',
            'unitprice' => 0,
            'unitpriceadd' => 0,
            'timebaseexp' => 0,
            'timebaseonline' => 0,
            'timeunitexp' => 0,
            'timeunitonline' => 0,
            'trafficunitdl' => 0,
            'trafficunitul' => 0,
            'trafficunitcomb' => 0,
            'inittimeexp' => 0,
            'inittimeonline' => 0,
            'initdl' => 0,
            'initul' => 0,
            'inittotal' => 0,
            'srvtype' => 0,
            'timeaddmodeexp' => 0,
            'timeaddmodeonline' => 0,
            'trafficaddmode' => 0,
            'monthly' => 0,
            'enaddcredits' => 0,
            'minamount' => 0,
            'minamountadd' => 0,
            'resetctrdate' => 0,
            'resetctrneg' => 0,
            'pricecalcdownload' => 0,
            'pricecalcupload' => 0,
            'pricecalcuptime' => 0,
            'unitpricetax' => 0,
            'unitpriceaddtax' => 0,
            'enableburst' => 0,
            'dlburstlimit' => 0,
            'ulburstlimit' => 0,
            'dlburstthreshold' => 0,
            'ulburstthreshold' => 0,
            'dlbursttime' => 0,
            'ulbursttime' => 0,
            'enableservice' => 1,
            'dlquota' => 0,
            'ulquota' => 0,
            'combquota' => 0,
            'timequota' => 0,
            'priority' => 0,
            'nextsrvid' => 0,
            'dailynextsrvid' => 0,
            'disnextsrvid' => 0,
            'availucp' => 0,
            'renew' => 0,
            'carryover' => 0,
            'policymapdl' => 0,
            'policymapul' => 0,
            'custattr' => 0,
            'gentftp' => 0,
            'cmcfg' => 0,
            'advcmcfg' => 0,
            'addamount' => 0,
            'ignstatip' => 0,
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
