<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $vouchers = Voucher::groupBy('series')->orderBy('id','desc')->get();
        $vouchers = Voucher::selectRaw('*, COUNT(*) as total')
                   ->groupBy('series')
                   ->orderBy('series', 'desc')
                   ->get();
        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plans = Plan::select('srvid','srvname')->get();
        return view('vouchers.create', compact('plans'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'valid_days' => 'required|integer|min:1',
            'prefix' => 'nullable|string|max:10',
            'pin_length' => 'required|integer|min:4|max:16',
            'password_length' => 'required|integer|min:4|max:8',
            'srvid' => 'required|exists:rm_services,srvid',
            'downlimit' => 'nullable|integer|min:0',
            'uplimit' => 'nullable|integer|min:0',
            'comblimit' => 'nullable|integer|min:0',
        ]);

        $vouchers = [];
        $date = Carbon::now();
        $expiration = $date->copy()->addDays($request->valid_days);
        $currentYear = $date->format('Y');

         // Get last series number
        $lastVoucher = Voucher::latest('id')->first();
        $lastNumber = $lastVoucher ? (int)substr($lastVoucher->series, 5) : 0;
        $seriesNumber = $lastNumber + 1;
        $series = $currentYear . '-' . str_pad($seriesNumber, 4, '0', STR_PAD_LEFT);
        
        for ($i = 0; $i < $request->quantity; $i++) {
            // Numeric card number
            $cardnum = $request->prefix . mt_rand(
                pow(10, $request->pin_length - 1),
                pow(10, $request->pin_length) - 1
            );

            // Numeric password
            $password = mt_rand(
                pow(10, $request->password_length - 1),
                pow(10, $request->password_length) - 1
            );

            $id = (Voucher::max('id') ?? 0) + $i + 1;
            $vouchers[] = [
                'id' => $id,
                'cardnum' => $cardnum,
                'password' => $password,
                'value' => 0,                
                'expiration' => $expiration->format('Y-m-d'),
                'series' => $series,
                'date' => $date->format('Y-m-d'),
                'owner' => auth()->user()->name ?? 'Admin',
                'used' => '0000-00-00 00:00:00',
                'cardtype' => 0,
                'revoked' => 0,
                'downlimit' => $request->downlimit ?? 0,
                'uplimit' => $request->uplimit ?? 0,
                'comblimit' => $request->comblimit ?? 0,
                'uptimelimit' => 0,
                'srvid' => $request->srvid,
                'transid' => '',
                'active' => 1,
                'expiretime' => 0,
                'timebaseexp' => 1,
                'timebaseonline' => 0,
            ];
        }
        // dd($vouchers);
        Voucher::insert($vouchers);

        return redirect()->route('vouchers.index')->with('success', $request->quantity . ' vouchers generated successfully.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cardnum' => 'required|unique:rm_cards',
            'password' => 'required',
            'value' => 'required|numeric',
            'expiration' => 'required|date',
            'series' => 'required',
        ]);

        // manually assign ID if not auto increment
        $nextId = RmCard::max('id') + 1;

        RmCard::create([
            'id' => $nextId,
            'cardnum' => $request->cardnum,
            'password' => $request->password,
            'value' => $request->value,
            'expiration' => $request->expiration,
            'series' => $request->series,
            'date' => now(),
            'owner' => $request->owner ?? '',
            'used' => $request->used ?? now(),
            'cardtype' => $request->cardtype ?? 0,
            'revoked' => $request->revoked ?? 0,
            'downlimit' => $request->downlimit ?? 0,
            'uplimit' => $request->uplimit ?? 0,
            'comblimit' => $request->comblimit ?? 0,
            'uptimelimit' => $request->uptimelimit ?? 0,
            'srvid' => $request->srvid ?? 0,
            'transid' => $request->transid ?? '',
            'active' => $request->active ?? 1,
            'expiretime' => $request->expiretime ?? 0,
            'timebaseexp' => $request->timebaseexp ?? 0,
            'timebaseonline' => $request->timebaseonline ?? 0,
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Card created successfully.');
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
        $voucher = Voucher::findOrFail($id);
        return view('vouchers.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
