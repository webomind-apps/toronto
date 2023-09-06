<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSubCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_id',
        'sub_category_id',
    ];

    public function subCategory()
    {
        return $this->hasOne(SubCategory::class,'id','sub_category_id');
    }
}
