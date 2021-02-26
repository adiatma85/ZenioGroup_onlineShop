<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'harga',
        'stok',
        'berat',
        'is_flashsale',
        'diskon',
        'deskripsi',
        'gambar',
        'kategori_id',
        'list_warna',
        'list_ukuran',
        'varian_lainnya',
        'list_varian_lainnya',
        'tags'
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id','id');
    }

    public function order_details()
    {
        return $this->hasMany(Order_detail::class,'product_id','id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class,'product_id','id');
    }
}
 