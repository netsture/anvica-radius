<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmUser;

class RadiusController extends Controller
{
    public function userIndex()
    {
        $users = RmUser::all();
        return view('radius/user.index', compact('users'));
    }
}
