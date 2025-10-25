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
                'Name' => $user->name,
                'Email' => $user->email,
                'Date of Birth' => $user->dob,
                'Mobile' => $user->mobile,
            ];
        });
    }

    public function headings(): array
    {
        return ['#','Identity','Username','Name','Email','Date of Birth','Mobile'];
    }
}
