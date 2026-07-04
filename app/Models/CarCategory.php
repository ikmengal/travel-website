<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'featured',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ------------------------------------- Relationships ------------------------------------- //
    // public function cars()
    // {
    //     return $this->hasMany(Car::class);
    // }

    // ------------------------------------- Query Scopes ------------------------------------- //
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // ------------------------------------- Accessor ------------------------------------- //
    public function getTotalCarsAttribute()
    {
        return $this->cars()->count();
    }
}
