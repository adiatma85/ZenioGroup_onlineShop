<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags_point extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tags',
        'tags_point',
        'tags_point_temp'
    ];
}
