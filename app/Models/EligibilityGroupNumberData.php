<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EligibilityGroupNumberData extends Model
{
    use HasFactory;

    protected $table = 'eligibility_group_number_data';

    protected $fillable = [
        'group_number',
        'group_name',
        'exam_data',
        'coverage_data',
    ];

    protected $casts = [
        'exam_data' => 'array', // Automatically convert JSON to array
        'coverage_data' => 'array', // Automatically convert JSON to array
    ];
}
