<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API Dokumentasi Dinas PUPR Katingan",
 *         version="1.0.0",
 *         description="API untuk mengakses data dan layanan Dinas PUPR Kabupaten Katingan",
 *         @OA\Contact(
 *             email="admin@pupr-katingan.go.id",
 *             name="Dinas PUPR Katingan"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000",
 *         description="Development Server"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class BaseApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/info",
     *     summary="Informasi API",
     *     description="Mendapatkan informasi dasar tentang API Dinas PUPR",
     *     tags={"System"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan informasi API",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="API Dinas PUPR berhasil diakses"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="API Dinas PUPR Katingan"),
     *                 @OA\Property(property="version", type="string", example="1.0.0"),
     *                 @OA\Property(property="description", type="string", example="API untuk layanan Dinas PUPR"),
     *                 @OA\Property(property="contact", type="string", example="admin@pupr-katingan.go.id")
     *             )
     *         )
     *     )
     * )
     */
    public function info()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API Dinas PUPR berhasil diakses',
            'data' => [
                'name' => 'API Dinas PUPR Katingan',
                'version' => '1.0.0',
                'description' => 'API untuk layanan Dinas PUPR',
                'contact' => 'admin@pupr-katingan.go.id',
                'timestamp' => now()->toISOString()
            ]
        ]);
    }
}
