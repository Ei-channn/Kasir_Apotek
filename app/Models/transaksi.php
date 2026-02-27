<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditLog;

class transaksi extends Model
{
    use AuditLog;

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
        return $this->hasMany(detail_transaksi::class);
    }
}
