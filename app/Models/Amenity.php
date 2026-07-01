<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use SoftDeletes;

    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(
            Hotel::class,
            'hotel_amenities'
        )->withTimestamps();
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(
            Room::class,
            'room_amenities'
        )->withTimestamps();
    }

    public function roomAmenities()
    {
        return $this->hasMany(RoomAmenity::class);
    }
}
