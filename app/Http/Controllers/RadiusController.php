<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmUser;

class RadiusController extends Controller
{
    public function userList()
    {
        $users = RmUser::all();
        // return view('radius/user.index', compact('users'));
        return view('radius/userlist', compact('users'));
    }
}
