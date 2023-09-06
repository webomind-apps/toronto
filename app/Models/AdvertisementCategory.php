<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'advertisement_id',
        'category_id',
    ];

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

}
