<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'gambar'
    ];
    public function products()
    {
        return $this->hasMany(Product::class,'kategori_id','id');
    }
}
