<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'page_type',
        'featured_image',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    // ---------------- Scopes ---------------- //
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
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    // ---------------- Accessor ---------------- //
    public function getImageAttribute()
    {
        if ($this->featured_image && file_exists(public_path('images/pages/' . $this->featured_image))) {
            return asset('images/pages/' . $this->featured_image);
        }
        return asset('admin/assets/img/placeholder.jpg');
    }

    // ---------------- Constants ---------------- //
    const PAGE_TYPES = [
        'about' => 'About Us',
        'contact' => 'Contact Us',
        'privacy-policy' => 'Privacy Policy',
        'terms-conditions' => 'Terms & Conditions',
        'refund-policy' => 'Refund Policy',
        'cancellation-policy' => 'Cancellation Policy',
        'cookie-policy' => 'Cookie Policy',
        'why-choose-us' => 'Why Choose Us',
        'custom' => 'Custom Page',
    ];
}
