<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    // Accept filtered users from controller
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Map each user to match table columns
        return $this->users->map(function ($user, $index) {
            return [
                '#' => $index + 1,
                'Identity' => $user->identity->name ?? 'Admin',
                'Username' => $user->username,
                'Name' => $user->name,
                'Email' => $user->email,
                'Date of Birth' => $user->dob,
                'Mobile' => $user->mobile,
                'Role' => implode(', ', $user->getRoleNames()->toArray()),
                'Status' => $user->status ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return ['#','Identity','Username','Name','Email','Date of Birth','Mobile','Role','Status'];
    }
}
