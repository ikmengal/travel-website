<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'max_adults',
        'max_children',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    // ------------------------------------- Scopes ------------------------------------- //
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
