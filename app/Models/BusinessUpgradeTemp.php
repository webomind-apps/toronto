<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BusinessUpgradeTemp extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_temp_id',
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
        return (new Carbon($value))->format('d M, Y');
    }

    public function getExpiredDateAttribute($value)
    {
        return (new Carbon($value))->format('d M, Y');
    }

    // public function setUpgradedDateAttribute( $value ) {
    //     $this->attributes['upgraded_date'] = (new Carbon($value))->format('Y-m-d');
    // }

    // public function setExpiredDateAttribute( $value ) {
    //     $this->attributes['expired_date'] = (new Carbon($value))->format('Y-m-d');
    // }
}
