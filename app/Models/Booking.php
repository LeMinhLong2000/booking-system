<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'notes',
    ];

    use HasFactory;

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
