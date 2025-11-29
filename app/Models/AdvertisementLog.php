<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementLog extends Model
{
    public $timestamps = false; // we use clicked_at instead

    protected $fillable = [
        'advertisement_id',
        'identity_id',
        'mac',
        'ip',
        'user_agent',
        'nas_id',
        'session_id',
        'clicked_at',
    ];
}
