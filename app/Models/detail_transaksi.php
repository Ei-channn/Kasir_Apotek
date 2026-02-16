<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    protected $fillable = [
        'transaksi_id',
        'obat_id',
        'jumlah',
        'harga_satuan',
        'total_harga',
    ];
    
    public function transaksi()
    {
        return $this->belongsTo(transaksi::class);
    }
}
