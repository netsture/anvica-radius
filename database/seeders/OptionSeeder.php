<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    public function run()
    {
        $options = [
             // Status (Active/Inactive)
            ['category' => 'status', 'key' => 'Active', 'value' => 'Active'],
            ['category' => 'status', 'key' => 'Inactive', 'value' => 'Inactive'],

            // Options (Yes/No)
            ['category' => 'yesno', 'key' => 'Yes', 'value' => 'Yes'],
            ['category' => 'yesno', 'key' => 'No', 'value' => 'No'],

            // Group Name (Yes/No)
            ['category' => 'role_group_name', 'key' => 'User', 'value' => 'User'],
            ['category' => 'role_group_name', 'key' => 'Patient', 'value' => 'Patient'],
            ['category' => 'role_group_name', 'key' => 'Office', 'value' => 'Office'],
            ['category' => 'role_group_name', 'key' => 'Proiveder', 'value' => 'Proiveder'],
            ['category' => 'role_group_name', 'key' => 'Eligibility', 'value' => 'Eligibility'],
        ];

        foreach ($options as $option) {
            Option::create($option);
        }

    }
}
