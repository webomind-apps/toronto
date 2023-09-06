<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTemp extends Model
{
    use HasFactory;
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
}
