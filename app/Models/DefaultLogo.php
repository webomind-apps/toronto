<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultLogo extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'status',
        'created_by',
        'updated_by',
    ];
}
