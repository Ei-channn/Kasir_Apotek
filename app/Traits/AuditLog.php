<?php

namespace App\Traits;

use App\Models\Log;

trait AuditLog
{
    protected static function bootAuditLog()
    {
        static::created(function ($model) {
            Log::create([
                'user_id' => auth()->id(),
                'action' => 'create',
                'tabel' => $model->getTable(),
                'data_id' => $model->id,
                'data_lama' => null,
                'data_baru' => $model->toArray(),
                'ip_address' => request()->ip(),
            ]);
        });

        static::updated(function ($model) {
            Log::create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'tabel' => $model->getTable(),
                'data_id' => $model->id,
                'data_lama' => $model->getOriginal(),
                'data_baru' => $model->getChanges(),
                'ip_address' => request()->ip(),
            ]);
        });

        static::deleted(function ($model) {
            Log::create([
                'user_id' => auth()->id(),
                'action' => 'delete',
                'tabel' => $model->getTable(),
                'data_id' => $model->id,
                'data_lama' => $model->toArray(),
                'data_baru' => null,
                'ip_address' => request()->ip(),
            ]);
        });
    }
}