<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\Rule;


class RoomController extends Controller
{
    // List all rooms (paginated newest first)
    public function index()
    {
        // Use pagination so it's performant; newest first
        $rooms = Room::orderBy('id', 'desc')->paginate(20);

        return view('rooms.index', compact('rooms'));
    }

    // Show create form
    public function create()
    {
        // identities for the select box (if you need them)
        if (empty(auth()->user()->identity_id)) {
            $identities = Identity::select('id', 'name')->orderBy('name')->get();
        } else {
            $identities = Identity::select('id', 'name')->where('id', auth()->user()->identity_id)->get();
        }

        return view('rooms.create', compact('identities'));
    }

    // Store single room
    public function store(Request $request)
    {
        $request->validate([
            'identity_id' => 'required|exists:identities,id',
            'room_no' => [
                'required',
                'string',
                Rule::unique('rooms', 'room_no')
                    ->where(fn ($query) => $query->where('identity_id', $request->identity_id)),
            ],
            'floor_no'  => 'required|string',
            'room_type' => 'required|string',
        ]);
        

        // Auto-generate series if you want (optional)
        $date = Carbon::now();
        $currentYear = $date->format('Y');
        $lastRoom = Room::latest('id')->first();
        $lastNumber = 0;
        if ($lastRoom && !empty($lastRoom->series)) {
            $parts = explode('-', $lastRoom->series);
            $lastNumber = is_numeric(end($parts)) ? (int)end($parts) : 0;
        }
        $seriesNumber = $lastNumber + 1;
        $autoSeries = $currentYear . '-' . str_pad($seriesNumber, 4, '0', STR_PAD_LEFT);

        $room = Room::create([
            'identity_id' => $request->identity_id ?? null,
            'room_no'     => $request->room_no,
            'floor_no'    => $request->floor_no,
            'room_type'   => strtolower($request->room_type),
            'status'      => $request->status,
            'series'      => $request->series ?? $autoSeries,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created: ' . $room->room_no);
    }
    // Show edit form
public function edit($id)
{
    $room = \App\Models\Room::findOrFail($id);

    if (empty(auth()->user()->identity_id)) {
        $identities = \App\Models\Identity::select('id','name')->orderBy('name')->get();
    } else {
        $identities = \App\Models\Identity::select('id','name')->where('id', auth()->user()->identity_id)->get();
    }

    return view('rooms.edit', compact('room','identities'));
}

// Update room
public function update(Request $request, $id)
{
    $room = Room::findOrFail($id);

    $request->validate([
        'identity_id' => 'nullable|exists:identities,id',
        'room_no'     => "required|string|unique:rooms,room_no,{$id}",
        'floor_no'    => 'required|string',
        'room_type'   => 'required|string',
        'status'      => 'required|string|in:available,occupied',
    ]);

    $room->update([
        'identity_id' => $request->identity_id ?? null,
        'room_no'     => $request->room_no,
        'floor_no'    => $request->floor_no,
        'room_type'   => strtolower($request->room_type),
        'status'      => $request->status,
    ]);

    return redirect()->route('rooms.index')->with('success', 'Room updated: ' . $room->room_no);
}

// Delete room
public function destroy($id)
{
    $room = Room::findOrFail($id);
    $room->delete();

    return redirect()->route('rooms.index')->with('success', 'Room deleted.');
}
}
