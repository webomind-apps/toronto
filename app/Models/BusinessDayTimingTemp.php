<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDayTimingTemp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_temp_id',
        'day',
        'time',
        'from_time',
        'to_time',
    ];
}
