<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/berita",
     *     summary="Daftar Berita",
     *     tags={"Berita"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Jumlah berita per halaman",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Data berita berhasil diambil")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search');

        $query = Berita::where('status', 'published')
            ->where('tanggal_publikasi', '<=', now())
            ->orderBy('tanggal_publikasi', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('konten', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $berita = $query->paginate($limit);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berita berhasil diambil',
            'data' => $berita->items(),
            'meta' => [
                'total' => $berita->total(),
                'per_page' => $berita->perPage(),
                'current_page' => $berita->currentPage(),
                'last_page' => $berita->lastPage(),
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/berita/{id}",
     *     summary="Detail Berita",
     *     tags={"Berita"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID Berita",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Detail berita berhasil diambil")
     *         )
     *     )
     * )
     */
    public function show($id)
    {
        $berita = Berita::where('id', $id)
            ->where('status', 'published')
            ->where('tanggal_publikasi', '<=', now())
            ->first();

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Increment views
        $berita->increment('views');

        return response()->json([
            'status' => 'success',
            'message' => 'Detail berita berhasil diambil',
            'data' => $berita
        ]);
    }
}
