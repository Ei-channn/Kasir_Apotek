<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'tabel',
        'data_id',
        'data_lama',
        'data_baru',
        'ip_address'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
