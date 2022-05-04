<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'password',
        'dob',
        'phone',
    ];

    protected $appends = [
        'full_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'avatar' => 'images/users/default-user.png'
    ];

    public function cartProducts()
    {
        return $this->belongsToMany(ProductVariant::class, 'cart_products')->withPivot('quantity')->withTimestamps();
    }

    public function getAvatarAttribute($value)
    {
        return asset("storage/$value");
    }

    public function getEmailAttribute($value)
    {
        return preg_replace("/(?!^).(?=[^@]+@)/", "*", $value);
    }

    public function getFullNameAttribute($value)
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin()
    {
        return $this->role_id == 0;
    }
}
