<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('id','desc')->get();
        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vouchers.create');
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
