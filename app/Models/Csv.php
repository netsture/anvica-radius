<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Csv extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 
        'dob', 
        'insurance_name', 
        'subscriber_id', 
        'provider_full_name', 
        'billing_date', 
        'procedure_code', 
        'tooth', 
        'surface', 
        'quadrant', 
        'cost',
    ];
}
