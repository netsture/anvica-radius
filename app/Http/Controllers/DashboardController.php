<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Identity;
use App\Models\RmUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $identityCount = Identity::count();
        $rmUserCount = RmUser::count();
        $advertisementCount = Advertisement::count();
        return view('admin.dashboard', compact('identityCount', 'rmUserCount', 'advertisementCount'));
    }
}
