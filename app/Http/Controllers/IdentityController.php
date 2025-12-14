<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identity;
use Illuminate\Support\Facades\Auth;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $identities = Identity::orderBy('id', 'desc')->paginate(15);
        return view('identities.index', compact('identities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('identities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'name'   => 'required|string|max:255',
    //         'status' => 'nullable|in:0,1'
    //     ]);

    //     $userId = Auth::id() ?? session('id');

    //     $identity = Identity::create([
    //         'name' => $data['name'],
    //         'status' => $data['status'] ?? 1,
    //         'created_by' => $userId,
    //         'updated_by' => $userId,
    //     ]);

    //     return redirect()->route('identities.index')
    //                      ->with('success', 'Identity created successfully.');
    // }

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
    public function edit(Identity $identity)
    {
        return view('identities.edit', compact('identity'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'mac' => 'required|string|max:191',
            'model' => 'required|string|max:191',
            'serial' => 'required|string|max:191',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zone' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:100',
            'society' => 'nullable|in:super premium,premium',
        ]);

        $data['otp_sms'] = $request->has('otp_sms') ? 1 : 0;
        $data['otp_whatsapp'] = $request->has('otp_whatsapp') ? 1 : 0;
        $data['otp_email'] = $request->has('otp_email') ? 1 : 0;
        $data['created_by'] = auth()->id() ?? null;

        Identity::create($data);

        return redirect()->route('identities.index')->with('success', 'Identity created.');
    }

    public function update(Request $request, Identity $identity)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'mac' => 'required|string|max:191',
            'model' => 'required|string|max:191',
            'serial' => 'required|string|max:191',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zone' => 'nullable|string|max:100',
            'area' => 'nullable|string|max:100',
            'society' => 'nullable|in:super premium,premium',
        ]);

        $data['otp_sms'] = $request->has('otp_sms') ? 1 : 0;
        $data['otp_whatsapp'] = $request->has('otp_whatsapp') ? 1 : 0;
        $data['otp_email'] = $request->has('otp_email') ? 1 : 0;
        $data['updated_by'] = auth()->id() ?? null;

        $identity->update($data);

        return redirect()->route('identities.index')->with('success', 'Identity updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Identity $identity)
    {
        $identity->delete();
        return redirect()->route('identities.index')
            ->with('success', 'Identity deleted successfully.');
    }
}
