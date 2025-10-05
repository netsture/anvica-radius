<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $identities = DB::table('identities')->pluck('name', 'id'); 
        $roles = Role::all();
        return view('users.create', compact('roles', 'identities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'identity_id' => 'required',
            'role' => 'required',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required',
            'password' => 'required|min:6|confirmed',

            'identity_id' => [
                Rule::requiredIf(function () use ($request) {
                    return in_array($request->role, ['provider', 'user']);
                }),
                'nullable',
                'exists:identities,id',
            ],
        ]);
        
        $user = new User();
        $user->identity_id = $request->identity_id;
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->home = $request->home;
        $user->password = bcrypt($request->password);
        $user->password_hint = $request->password;
        $user->role = $request->role;
        $user->save();
        
        if($request->role){
            $user->assignRole($request->role);
        }
        return redirect()->route('users.index');
        // return redirect()->route('users.index')->with('success', 'User created successfully.');
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
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required',
            'role' => 'required|in:admin,billing_coordinator,insurance_coordinator,office_manager',
            'password' => $request->password ? 'nullable|min:8|confirmed' : '', // Only validate password if it's provided
        ]);
    
        $data = $request->except(['password']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        

        $user->update($data);
        // $user->update($request->all());
    
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}

