<?php

namespace App\Exports;

use App\Models\RmUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RmUsersExport implements FromCollection, WithHeadings
{
    protected $users;

    // Accept a collection of users
    public function __construct($users)
    {
        $this->users = $users;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->users->map(function ($user, $index) {
            return [
                '#' => $index + 1,
                'Identity' => $user->identity->name ?? '',
                'Username' => $user->username,
                'OTP' => $user->otp ?? "N/A",
                'MAC Address' => $user->mac ?? "",
                'Last Logoff' => viewDateTime($user->lastlogoff),
                'Created Date' => viewDate($user->createdon),
            ];
        });
    }

    public function headings(): array
    {
        return ['#','Identity','Username','OTP','MAC Address','Last Logoff','Created Date'];
    }
}
