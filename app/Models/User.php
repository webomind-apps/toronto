<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var string[]
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'password',
        'address',
        'lat',
        'lng',
        'postcode',
        'country_id',
        'province_id',
        'city_id',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class,'id','province_id');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class,'user_id','id');
    }
}
