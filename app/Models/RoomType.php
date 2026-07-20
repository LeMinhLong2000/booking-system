<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'price_per_night',
        'capacity',
        'description',
        'is_active',
    ];
    use HasFactory;

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
