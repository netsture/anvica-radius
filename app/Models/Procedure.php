<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'insurance_id',
        'provider_id',
        'dos',
        'procedure_code',
        'tooth',
        'surface',
        'quadrant',
        'amount',
        'created_by',
        'updated_by',
    ];

    // Define relationships if needed
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
