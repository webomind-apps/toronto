<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSubCategoryTemp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_temp_id',
        'sub_category_id',
    ];
}
