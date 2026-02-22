<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\log;
use App\Models\User;
use App\Http\Resources\ApiResource;

class logController extends Controller
{
    public function index()
    {
        $logs = Log::with('user')->latest()->paginate(10);

        if ($logs->isEmpty()) {
            return new ApiResource(null, false, 'Tidak ada data log');
        }

        return new ApiResource($logs, true, 'Logs berhasil diambil');
    }
}
