<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPaymentMethodTemp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_temp_id',
        'payment_method_id',
    ];
}
