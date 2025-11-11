<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserLogsExport implements FromCollection, WithHeadings
{
    protected $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function collection()
    {
        $identityId = auth()->user()->identity_id ?? null;
        // dd($identityId);
        return DB::table('radacct as r')
            ->leftJoin('radius.rm_users as u', 'r.username', '=', 'u.username')
            ->select(
                'r.username',
                'r.callingstationid',
                'r.framedipaddress',
                'r.acctstarttime',
                'r.acctstoptime',
                'r.acctsessiontime',
                'u.identity_id'
            )
            ->when($identityId, fn($q) => $q->where('u.identity_id', $identityId))
            ->when(!empty($this->username ?? null), fn($q) => $q->where('r.username', $this->username))
            ->get();

        return DB::table('radacct')
            ->select('username', 'callingstationid', 'framedipaddress', 'acctstarttime', 'acctstoptime', 'acctsessiontime')
            ->when(!empty($this->username), function ($query) {
                $query->where('username', $this->username);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'Username',
            'MAC',
            'Ipaddress',
            'Login',
            'Logout',
            'Session Time',
        ];
    }
}
?>