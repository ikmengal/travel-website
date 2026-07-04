<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Database\Factories\UserFactory;
use Spatie\MediaLibrary\HasMedia;

// #[Fillable(['name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]
#[Fillable([
    'slug',
    'name',
    'username',
    'email',
    'phone',
    'password',
    'avatar',
    'country_id',
    'state_id',
    'city_id',
    'gender',
    'date_of_birth',
    'address',
    'bio',
    'status',
    'email_verified_at',
])]

#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function bookingNotes()
    {
        return $this->hasMany(BookingNote::class);
    }

    public function bookingStatusHistories()
    {
        return $this->hasMany(BookingStatusHistory::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class);
    }

    public function getProfilePictureAttribute()
    {
        if ($this->avatar &&
            file_exists(public_path('images/users/'.$this->avatar))) {
            return asset('images/users/'.$this->avatar);
        }
        return asset('images/users/user1.png');
    }

    public function country(){
        return $this->hasOne(Country::class, 'id', 'country_id',);
    }

    public function state(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }

}
