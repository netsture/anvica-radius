<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'npi',
        'tin',
        'taxonomy_number',
        'logo',
        'photo',
        'created_by',
        'updated_by',
        'user_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'office_user');
    }

    /**
     * Define the relationship to the user who created the office.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Define the relationship to the user who last updated the office.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Define the relationship to the user associated with the office.
     */
}
