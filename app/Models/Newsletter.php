<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsletter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'token',
        'subscribed_at',
        'verified_at',
        'unsubscribed_at',
        'unsubscribe_reason',
        'ip_address',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'subscribed_at' => 'datetime',
        'verified_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
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

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    public function scopeSubscribed($query)
    {
        return $query->whereNull('unsubscribed_at');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsSubscribedAttribute()
    {
        return is_null($this->unsubscribed_at);
    }

    public function getIsVerifiedAttribute()
    {
        return ! is_null($this->verified_at);
    }
}
