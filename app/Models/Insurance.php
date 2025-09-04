<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'phone',
        'phone_ext',
        'fax',
        'fax_ext', 
        'website',
        'email',
        'address1',
        'address2',
        'city', 
        'state', 
        'zipcode', 
        'country', 
        'created_by', 
        'updated_by',
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
