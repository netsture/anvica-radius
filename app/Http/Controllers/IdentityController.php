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
        $identities = Identity::orderBy('id','desc')->paginate(15);
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'nullable|in:0,1'
        ]);

        $userId = Auth::id() ?? session('id');

        $identity = Identity::create([
            'name' => $data['name'],
            'status' => $data['status'] ?? 1,
            'created_by' => $userId,
            'updated_by' => $userId,
        ]);

        return redirect()->route('identities.index')
                         ->with('success', 'Identity created successfully.');
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
    public function edit(Identity $identity)
    {
        return view('identities.edit', compact('identity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Identity $identity)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'nullable|in:0,1'
        ]);

        $userId = Auth::id() ?? session('id');

        $identity->update([
            'name' => $data['name'],
            'status' => $data['status'] ?? 1,
            'updated_by' => $userId,
        ]);

        return redirect()->route('identities.index')
                         ->with('success', 'Identity updated successfully.');
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
