<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarFeature extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',

        'slug',

        'icon',

        'description',

        'featured',

        'status',

        'sort_order',

    ];

    protected $casts = [

        'featured' => 'boolean',

        'status' => 'boolean',

        'sort_order' => 'integer',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function cars()
    {
        return $this->belongsToMany(
            Car::class,
            'car_feature_car'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

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
}
