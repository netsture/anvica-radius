<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EligibilityPatient extends Model
{
    use HasFactory;

    protected $table = 'eligibility_patients';

    protected $fillable = [
        'patient_id',
        'office_id',
        'provider_id',
        'primary_insurance_id',
        'secondary_insurance_id',
        'appt_date',
        'appt_time',
        'prim_subscriber',
        'prim_carrier_name',
        'prim_subscriber_id',
        'sec_carrier_name',
        'sec_subscriber_id',
        'created_by', 
        'updated_by'
    ];

    protected $casts = [
        'verified_date' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function primaryInsurance()
    {
        return $this->belongsTo(Insurance::class, 'primary_insurance_id');
    }

    public function secondayInsurance()
    {
        return $this->belongsTo(Insurance::class, 'secondary_insurance_id');
    }
}
