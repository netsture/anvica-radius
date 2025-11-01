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
        return DB::table('radacct')
            ->select('username', 'callingstationid', 'framedipaddress' ,'acctstarttime' ,'acctstoptime' ,'acctsessiontime')
            ->where('username', $this->username)
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