<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'ref_no',
        'email',
        'score',
        'comment',
        'image',
        'status',
        'created_by',
        'updated_by',
    ];
    public function business()
    {
        return $this->hasOne(Business::class,'id','business_id');
    }
}
