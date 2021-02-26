<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable  = [
        'kode',
        'status',
        'total_harga',
        'unik',
        'is_refund',
        'no_resi',
        'catatan',
        'bukti_refund',
        'user_id',
        'pesan'
    ];
    public function order_details()
    {
        return $this->hasMany(Order_detail::class,'order_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
