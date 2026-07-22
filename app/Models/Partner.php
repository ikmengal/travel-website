<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'website',
        'logo',
        'sort_order',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

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
        return $query
            ->orderBy('sort_order')
            ->orderByDesc('created_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getLogoAttribute($value)
    {
        if ($value && file_exists(public_path('images/partners/' . $value))) {
            return asset('images/partners/' . $value);
        }

        return asset('admin/assets/img/placeholder.jpg');
    }
}
