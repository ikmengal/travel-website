<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoomPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_room_id',
        'title',
        'start_date',
        'end_date',
        'price',
        'discount_price',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'status' => 'boolean',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function room()
    {
        return $this->belongsTo(
            HotelRoom::class,
            'hotel_room_id'
        );
    }

    // ------------------------------------- Scopes ------------------------------------- //
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeCurrent($query)
    {
        return $query->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }

    // ------------------------------------- Accessor ------------------------------------- //
    public function getCurrentPriceAttribute()
    {
        return $this->discount_price
            ?? $this->price;
    }
}
