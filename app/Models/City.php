<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country_id',
        'province_id',
        'status',
        'created_by',
        'updated_by',
    ];
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

}
