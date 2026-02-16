<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'no_transaksi',
        'user_id',
        'bayar',
        'total_harga',
        'kembalian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
