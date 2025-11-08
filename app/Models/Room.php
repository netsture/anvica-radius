<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'identity_id',
        'room_no',
        'floor_no',
        'room_type',
        'status',
    ];

    protected $casts = [
        // add casts if needed, e.g. created_at handled by Eloquent
    ];

    public function identity()
    {
        return $this->belongsTo(Identity::class, 'identity_id');
    }
}
