<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::all(); // Fetch all offices
        return view('offices.index', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('offices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $officeData = $request->all();
        $officeData['created_by'] = Auth::id();
        $officeData['updated_by'] = Auth::id();

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $officeData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('photo')) {
            $officeData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Office::create($officeData);

        $notification = array(
            'message' => 'Office created successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('offices.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        return view('offices.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $office = Office::findOrFail($id);

        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'phone_ext' => 'nullable|string|max:10',
            'fax' => 'nullable|string|max:20',
            'fax_ext' => 'nullable|string|max:10',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'npi' => 'nullable|string|max:20',
            'tin' => 'nullable|string|max:20',
            'taxonomy_number' => 'nullable|string|max:50',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Update the office details
        $office->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'phone_ext' => $validated['phone_ext'],
            'fax' => $validated['fax'],
            'fax_ext' => $validated['fax_ext'],
            'website' => $validated['website'],
            'email' => $validated['email'],
            'address1' => $validated['address1'],
            'address2' => $validated['address2'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zipcode' => $validated['zipcode'],
            'country' => $validated['country'],
            'npi' => $validated['npi'],
            'tin' => $validated['tin'],
            'taxonomy_number' => $validated['taxonomy_number'],
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads/logos', 'public');
            $office->update(['logo' => $logoPath]);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photos', 'public');
            $office->update(['photo' => $photoPath]);
        }

        $notification = array(
            'message' => 'Office details updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('offices.index')->with($notification);
        // Redirect to the index page with a success message
        // return redirect()->route('offices.index')->with('success', 'Office details updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();
        $notification = array(
            'message' => 'Office deleted successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('offices.index')->with($notification);
        // return redirect()->route('offices.index')->with('success', 'Office deleted successfully.');
    }
}
