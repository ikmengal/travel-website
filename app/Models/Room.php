<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(
            Amenity::class,
            'room_amenities'
        )->withTimestamps();
    }
}
