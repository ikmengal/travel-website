<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'subtitle_1',
        'subtitle_2',
        'subtitle_3',
        'description',
        'avatars_data',
        'card_location',
        'card_para',
        'card_reviews',
        'tag_icon',
        'tag_heading',
        'tag_para',
        'button_text',
        'button_url',
        'image',
        'featured',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    // -------------------- Scopes -------------------- //
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
        return $query->orderBy('sort_order')
                     ->orderByDesc('created_at');
    }

    // ----------------- Accessor ----------------- //
    public function getimageAttribute($value)
    {
        if ($value && file_exists(public_path('images/banners/'.$value))) {
            return asset('images/banners/'.$value);
        }
        return asset('images/destinations/hero.jpg');
    }
}
