<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use Illuminate\Support\Facades\Auth;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $insurances = Insurance::all();
        return view('insurances.index', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:15',
            'fax_ext' => 'nullable|string|max:10',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:50',
        ]);

        $validated['created_by'] = Auth::id();

        Insurance::create($validated);

        return redirect()->route('insurances.index')->with('success', 'Insurance created successfully.');
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
        $insurance = Insurance::findOrFail($id);
        return view('insurances.edit', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $insurance = Insurance::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:15',
            'fax_ext' => 'nullable|string|max:10',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:50',
        ]);

        $validated['updated_by'] = Auth::id();

        $insurance->update($validated);

        return redirect()->route('insurances.index')->with('success', 'Insurance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $insurance = Insurance::findOrFail($id);
        $insurance->delete();

        return redirect()->route('insurances.index')->with('success', 'Insurance deleted successfully.');
    }
}
