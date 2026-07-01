<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


class Hotel extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hotelType(): BelongsTo
    {
        return $this->belongsTo(HotelType::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenity::class,
            'hotel_amenities'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Future Relations
    |--------------------------------------------------------------------------
    */

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }

    // public function bookings()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}
