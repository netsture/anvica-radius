<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\RmUser;
use Illuminate\Support\Facades\Hash;

class RadiusUserController extends Controller
{
    public function index()
    {
        if (empty(auth()->user()->identity_id)) {
            $users = RmUser::all();
        } else {
            $users = RmUser::where('identity_id', auth()->user()->identity_id)->get();
        }

        // return view('radius/user.index', compact('users'));
        return view('radius-user/index', compact('users'));
    }

    public function create()
    {
        $plans = Plan::select('srvid','srvname')->get();

        if (empty(auth()->user()->identity_id)) {
            $identities = Identity::select('id', 'name')->orderBy('name')->get();
        } else {
            $identities = Identity::select('id', 'name')->where('id', auth()->user()->identity_id)->get();
        }
        // dd($identities);
        return view('radius-user/create', compact('plans', 'identities'));
    }

    public function store(Request $request)
    {
        $request->validate(RmUser::rules(null, $request->identity_id));

        $data = $request->all();
        $data['password'] = md5($request->password);
        // dd($data);
        RmUser::create($data);

        return redirect()->route('radius.users.index')->with('success', 'User created successfully.');
    }
}
