<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'priority',
        'status',
        'created_by',
        'updated_by',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class,'category_id','id')->orderBy("name","asc");
    }
}
