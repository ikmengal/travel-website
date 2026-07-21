<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // ----------------- Relationships ----------------- //
    /**
     * Blogs
     */
    public function blogs()
    {
        return $this->belongsToMany(
            Blog::class,
            'blog_blog_tags',
            'blog_tag_id',
            'blog_id'
        )->withTimestamps();
    }

    // ----------------- Scopes ----------------- //
    /**
     * Active Tags
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Ordered Tags
     */
    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
