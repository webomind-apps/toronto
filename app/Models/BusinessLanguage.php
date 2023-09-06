<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessLanguage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'business_id',
        'language_id',
    ];

    public function language()
    {
        return $this->hasOne(Language::class,'id','language_id');
    }
}
