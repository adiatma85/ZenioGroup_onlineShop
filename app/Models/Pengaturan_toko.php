<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan_toko extends Model
{
    use HasFactory;
    protected $fillable = [
        'kota_id',
        'provinsi_id',
        'nama_kota',
        'no_telepon',
        'nama_flashsale',
        'jasa_pengiriman'
    ];
    
}
