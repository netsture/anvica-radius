<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eligibility extends Model
{
    use HasFactory;

    protected $table = 'eligibilities'; // Specify the table name (optional if it's plural of the model name)

    // The attributes that are mass assignable.
    protected $fillable = [
        'patient_id',
        'insurance_id',
        'is_eligible',
        'policy_holder_name',
        'policy_holder_dob',
        'insurance_name',
        'network_status',
        'member_id',
        'group_name',
        'group_number',
        'effective_date',
        'end_date',
        'claims_filing_limit',
        'life_time',
        'waiting_period',
        'missing_tooth_clause',
        'ortho_maximum',
        'ortho_remaining_maximum',
        'ortho_age_limit',
        'annual_maximum',
        'remaining_maximum',
        'plan_year',        
        'deductible_applies_to',
        'preventive_waived',
        'deductibles_data',
        'exam_data',
        'coverage_data',
        'required_preauth_xray_data',
        'fluoride_sealants_data',
        'share_history_data',
        'verified_date',
        'verified_by',
        'insurance_rep_name',
        'insurance_reference_number',
        'additional_notes',
    ];

    // Casting JSON columns to arrays
    protected $casts = [
        'deductibles_data' => 'array',
        'exam_data' => 'array',
        'coverage_data' => 'array',
        'required_preauth_xray_data' => 'array',
        'fluoride_sealants_data' => 'array',  // Convert JSON to array
        'share_history_data' => 'array',  // Convert JSON to array
        'verified_date' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
    
}
