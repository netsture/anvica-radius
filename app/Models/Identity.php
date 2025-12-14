<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    protected $table = 'identities';

    protected $fillable = [
        'name',
        'status',
        'mac',
        'model',
        'serial',
        'country',
        'state',
        'city',
        'zone',
        'area',
        'society',
        'otp_sms',
        'otp_whatsapp',
        'otp_email',
        'created_by',
        'updated_by'
    ];

    // optional relations
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
}
