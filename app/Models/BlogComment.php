<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'blog_id',
        'parent_id',
        'name',
        'email',
        'website',
        'ip_address',
        'comment',
        'status',
        'approved_at',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'approved_at' => 'datetime',
    ];

    //-------------- Relationships -------------- //
    /**
     * Blog
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Parent Comment
     */
    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    /**
     * Replies
     */
    public function children()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('created_at');
    }

    //-------------- Scopes -------------- //
    /**
     * Approved Comments
     */
    public function scopeApproved($query)
    {
        return $query->where('status', true);
    }

    /**
     * Pending Comments
     */
    public function scopePending($query)
    {
        return $query->where('status', false);
    }

    /**
     * Parent Comments
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Replies Only
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
