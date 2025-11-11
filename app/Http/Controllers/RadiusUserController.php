<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\RmUser;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RmUsersExport;
use App\Exports\UserLogsExport;

class RadiusUserController extends Controller
{
    public function index(Request $request)
    {
        $query = RmUser::query();

        // Filter by identity (Admin vs Specific Identity)
        if (!empty(auth()->user()->identity_id)) {
            $query->where('identity_id', auth()->user()->identity_id);
        }

        // Filter by From and To Date
        if ($request->filled('from_date')) {
            $query->whereDate('createdon', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('createdon', '<=', $request->to_date);
        }

        // Fetch results (you can also paginate if needed)
        $users = $query->orderBy('createdon', 'desc')->get();

        return view('radius-user.index', compact('users'));
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

    public function exportExcel(Request $request)
    {
        $query = RmUser::query();
        // Identity filter
        if (!empty(auth()->user()->identity_id)) {
            $query->where('identity_id', auth()->user()->identity_id);
        }

        // Date filters
        if ($request->filled('from_date')) {
            $query->whereDate('createdon', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('createdon', '<=', $request->to_date);
        }

        $users = $query->orderBy('createdon', 'desc')->get();

        return Excel::download(new RmUsersExport($users), 'rm_users.xlsx');
    }

    public function logs(Request $request)
    {
        $username = $request->get('username');
        $logs = \DB::select("SELECT * FROM radacct WHERE username = ?", [$username]);
        return view('radius-user.user-logs', compact('username','logs'));
    }

    public function exportUserLogs(Request $request)
    {
        $username = $request->get('username');

        if (!$username) {
            return redirect()->back()->with('error', 'Username is required');
        }

        return Excel::download(new UserLogsExport($username), 'user_logs_' . $username . '.xlsx');
    }

    public function allLogs(Request $request)
    {
        $identityId = auth()->user()->identity_id ?? null;
        $sql = "SELECT r.* FROM radacct AS r LEFT JOIN rm_users AS u ON r.username = u.username";
        $params = [];
        if (!empty($identityId)) {
            $sql .= " WHERE u.identity_id = ?";
            $params[] = $identityId;
        }
        $sql .= " ORDER BY r.acctstarttime DESC";
        $logs = \DB::select($sql, $params);

        return view('radius-user.user-all-logs', compact('logs'));
    }

    public function exportUserAllLogs(Request $request)
    {
        return Excel::download(new UserLogsExport(''), 'user_logs_' . date('d-m-Y') . '.xlsx');
    }
}
