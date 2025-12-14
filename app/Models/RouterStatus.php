<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouterStatus extends Model
{
    use HasFactory;

    protected $table = 'router_status';

    protected $fillable = [
        'router',
        'status',
        'event_date',
        'event_time',
        'ip_address',
        'api_request',
    ];
}
