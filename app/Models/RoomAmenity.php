<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomAmenity extends Model
{
    protected $fillable = [
        'room_id',
        'amenity_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class);
    }
}
