<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|unique:providers,email',
            'cell_phone' => 'required|string|max:191',
            // Add more validation rules as needed
        ]);

        $request->merge([
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        Provider::create($request->all());

        return redirect()->route('providers.index')->with('success', 'Provider created successfully!');
    }

    public function show(Provider $provider)
    {
        return view('providers.show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email',
            'cell_phone' => 'required|string|max:191',
            // Add more validation rules as needed
        ]);
        $request->merge([
            'updated_by' => auth()->id(),
        ]);
        $provider->update($request->all());

        return redirect()->route('providers.index')->with('success', 'Provider updated successfully!');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index')->with('success', 'Provider deleted successfully!');
    }
}
