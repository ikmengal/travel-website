<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function hotels()
    {
        return $this->belongsToMany(
            Hotel::class,
            'hotel_amenity_hotel',
            'hotel_amenity_id',
            'hotel_id'
        )->withTimestamps();
    }

    // ------------------------------------- Query Scopes ------------------------------------- //
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
}
