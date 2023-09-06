<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'business_id',
        'business_user_id',
        'email',
        'phone',
        'message',
        'date',
        'status',
    ];

    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }

    public function business_user()
    {
        return $this->hasOne(BusinessUser::class,'id','business_user_id');
    }

}
