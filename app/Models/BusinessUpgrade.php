<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BusinessUpgrade extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'package_id',
        'gst_percentage',
        'gst_amount',
        'total_amount',
        'package_price',
        'upgraded_date',
        'expired_date',
        'status',
        'created_by',
        'updated_by',
    ];

    public function getUpgradedDateAttribute($value)
    {
        return (new Carbon($value))->format('d-m-Y');
    }

    public function getExpiredDateAttribute($value)
    {
        return (new Carbon($value))->format('d-m-Y');
    }

    public function package()
    {
        return $this->hasOne(Package::class,'id','package_id');
    }
}
