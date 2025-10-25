<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'srvid',
        'voucher_code',
        'series',
        'validity',
        'expiry_date',
        'used_date',
        'status',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'used_date' => 'date',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'srvid', 'srvid');
    }

    public function identity()
    {
        return $this->belongsTo(Identity::class, 'identity_id');
    }
}
