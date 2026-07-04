<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'url',
        'color',
        'open_in_new_tab',
        'is_footer',
        'is_header',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'is_footer' => 'boolean',
        'is_header' => 'boolean',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeHeader($query)
    {
        return $query->where('is_header', true);
    }

    public function scopeFooter($query)
    {
        return $query->where('is_footer', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
