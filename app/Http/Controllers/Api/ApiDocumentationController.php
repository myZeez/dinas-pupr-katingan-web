<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ApiDocumentationController extends Controller
{
    public function getDocumentation()
    {
        // Return static clean JSON file to avoid any HTML pollution
        $jsonPath = public_path('api-docs.json');

        if (!File::exists($jsonPath)) {
            return response()->json([
                'error' => 'Documentation file not found'
            ], 404);
        }

        $jsonContent = File::get($jsonPath);

        return response($jsonContent, 200, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function showDocumentation()
    {
        return view('api.documentation');
    }
}
