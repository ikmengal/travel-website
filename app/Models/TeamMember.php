<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'designation',
        'image',
        'short_bio',
        'email',
        'phone',
        'facebook',
        'instagram',
        'linkedin',
        'twitter',
        'youtube',
        'sort_order',
        'featured',
        'status',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'boolean',
    ];

    // ----------------- Scopes ----------------- //
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
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ----------------- Accessor ----------------- //
    public function getImageAttribute()
    {
        if (
            $this->attributes['image'] &&
            file_exists(public_path('images/team-members/'.$this->attributes['image']))
        ) {
            return asset('images/team-members/'.$this->attributes['image']);
        }
        return asset('admin/assets/img/avatars/1.png');
    }
}
