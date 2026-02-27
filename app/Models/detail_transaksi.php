<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditLog;

class detail_transaksi extends Model
{
    use AuditLog;

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

    public function obat()
    {
        return $this->belongsTo(obat::class);
    }
}
