<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPaymentMethod extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_id',
        'payment_method_id',
    ];

    public function PaymentMethod()
    {
        return $this->hasOne(PaymentMethod::class,'id','payment_method_id');
    }
}
