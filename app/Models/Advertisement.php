<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'image',
        'link',
        'price',
        'expired_date',
        'status',
        'file_status',
        'created_by',
        'updated_by',
    ];

    public function categories()
    {
        return $this->hasMany(AdvertisementCategory::class,'advertisement_id','id');
    }

    public function cities()
    {
        return $this->hasMany(AdvertisementCity::class,'advertisement_id','id');
    }

    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }

}
