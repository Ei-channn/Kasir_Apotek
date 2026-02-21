<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\log;

class logController extends Controller
{
    public function index()
    {
        $logs = Log::latest()->paginate(10);
        return response()->json($logs);
    }
}
