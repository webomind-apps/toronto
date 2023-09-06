<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementCity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'advertisement_id',
        'city_id',
    ];

    public function city()
    {
        return $this->hasOne(City::class,'id','city_id');
    }
}
