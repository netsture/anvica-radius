<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Models\User;

class OptionController extends Controller
{
    public function index()
    {
        // $options = Option::all();
        // $options = Option::orderBy('category')->get();
        $options = Option::orderBy('category')->get();
        $categories = Option::select('category')->distinct()->pluck('category');
        return view('options.index', compact('options', 'categories'));
    }

    public function create()
    {
        return view('options.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'key' => 'required|unique:options,key',
            'value' => 'required'
        ]);

        // dd($request);
        Option::create($request->all());

        return redirect()->route('options.index')->with('success', 'Option added successfully');
    }

    public function edit(Option $option)
    {
        $status = Option::where('category', 'status')->pluck('value', 'key');
        return view('options.edit', compact('option', 'status'));
    }

    public function update(Request $request, Option $option)
    {
        $request->validate([
            'category' => 'required',
            'key' => 'required|unique:options,key,' . $option->id,
            'value' => 'required'
        ]);

        $option->update($request->all());

        return redirect()->route('options.index')->with('success', 'Option updated successfully');
    }

    public function destroy(Option $option)
    {
        $option->delete();
        return redirect()->route('options.index')->with('success', 'Option deleted successfully');
    }

    public function delete($id)
    {
        $option = Option::find($id);

        if (!$option) {
            return redirect()->route('options.index')->with('error', 'Option not found.');
        }

        $option->delete();
        return redirect()->route('options.index')->with('success', 'Option deleted successfully!');
    }

    public function search(Request $request)
    {
        $search = $request->get('query');
        $categories = Option::where('category', 'LIKE', "%{$search}%")
                    ->groupBy('category') // Ensure unique categories
                    ->pluck('category');

        return response()->json($categories);
    }
    
}
