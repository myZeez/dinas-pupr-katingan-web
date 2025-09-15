<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwaggerController extends Controller
{
    public function json()
    {
        $swagger = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'API Dinas PUPR Katingan',
                'version' => '1.0.0',
                'description' => 'API Documentation untuk Dinas PUPR Kabupaten Katingan'
            ],
            'servers' => [
                [
                    'url' => 'http://127.0.0.1:8000',
                    'description' => 'Development Server'
                ]
            ],
            'paths' => [
                '/api/info' => [
                    'get' => [
                        'tags' => ['System'],
                        'summary' => 'API Information',
                        'responses' => [
                            '200' => [
                                'description' => 'Success',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'status' => [
                                                    'type' => 'string',
                                                    'example' => 'success'
                                                ],
                                                'message' => [
                                                    'type' => 'string',
                                                    'example' => 'API is working'
                                                ],
                                                'version' => [
                                                    'type' => 'string',
                                                    'example' => '1.0.0'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return response()->json($swagger, 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    public function ui()
    {
        return view('swagger.index');
    }
}
