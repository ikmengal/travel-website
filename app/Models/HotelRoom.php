<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelRoom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hotel_id',
        'hotel_room_type_id',
        'room_code',
        'name',
        'slug',
        'room_number',
        'bed_type',
        'beds',
        'bathrooms',
        'max_adults',
        'max_children',
        'room_size',
        'room_size_unit',
        'view',
        'short_description',
        'description',
        'base_price',
        'discount_price',
        'total_rooms',
        'available_rooms',
        'featured',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'featured' => 'boolean',
        'status' => 'boolean',
        'room_size' => 'decimal:2',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function roomType()
    {
        return $this->belongsTo(HotelRoomType::class,'hotel_room_type_id');
    }

    public function images()
    {
        return $this->hasMany(HotelRoomImage::class)
                    ->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(HotelRoomImage::class)
                    ->where('is_featured', true);
    }

    public function prices()
    {
        return $this->hasMany(HotelRoomPrice::class);
    }

    public function currentPrice()
    {
        return $this->hasOne(HotelRoomPrice::class)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function wishlists()
    {
        return $this->morphMany(
            Wishlist::class,
            'wishlistable'
        );
    }

    public function faqs()
    {
        return $this->morphMany(
            Faq::class,
            'faqable'
        );
    }

    // ------------------------------------- Query Scopes -------------------------------------//
    public function scopeActive($query)
    {
        return $query->where('status',true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured',true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_rooms','>',0);
    }

    // ------------------------------------- Accessors -------------------------------------//
    public function getCurrentPriceAttribute()
    {
        return $this->discount_price ?? $this->base_price;
    }

    public function reviews()
    {
        return $this->morphMany(
            Review::class,
            'reviewable'
        );
    }
}
