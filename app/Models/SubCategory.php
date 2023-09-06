<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'status',
        'created_by',
        'updated_by',
    ];
    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
}
