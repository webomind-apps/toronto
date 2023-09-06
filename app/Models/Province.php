<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function cities()
    {
        return $this->hasMany(City::class,'province_id','id')->orderBy("name","asc");
    }

}
