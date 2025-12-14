<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'advertiser_id', 'title', 'page_section', 'media_path', 'media_type', 'click_url',
        'start_at', 'end_at', 'time_slot', 'weekdays',
        'priority', 'max_impressions', 'max_clicks',
        'country', 'state', 'city', 'zone', 'area', 'society',
        'meta', 'created_by', 'updated_by', 'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'weekdays' => 'array',
        'meta'     => 'array',
    ];

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    public function logs()
    {
        return $this->hasMany(AdvertisementLog::class);
    }

    public function viewLogs()
    {
        return $this->hasMany(AdvertisementLog::class)->where('event', 'view');
    }

    public function clickLogs()
    {
        return $this->hasMany(AdvertisementLog::class)->where('event', 'click');
    }

}
