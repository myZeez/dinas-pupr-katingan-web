<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'DINAS PUPR API is running',
            'version' => '1.0.0',
            'timestamp' => now()->toISOString()
        ]);
    }

    public function hello()
    {
        return response()->json(['message' => 'Hello World']);
    }

    public function status()
    {
        try {
            \DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Exception $e) {
            $dbStatus = 'disconnected';
        }

        return response()->json([
            'status' => 'success',
            'database' => $dbStatus,
            'timestamp' => now()->toISOString()
        ]);
    }
}
