<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_room_id',
        'image',
        'title',
        'alt_text',
        'is_featured',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // ------------------------------------- Accessor ------------------------------------- //

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('public/images/hotel_roomes/' . $this->image)
            : asset('public/images/hotel_roomes/room.png');
    }
}
