<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Services\EmailNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PengaduanApiController extends Controller
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @OA\Post(
     *     path="/api/pengaduan",
     *     summary="Buat Pengaduan Baru",
     *     tags={"Pengaduan"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nama", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="judul", type="string", example="Jalan Rusak")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Pengaduan berhasil dikirim")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:infrastruktur,layanan,lingkungan,lainnya',
            'lokasi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Generate nomor tiket
        $data['nomor_tiket'] = 'TKT-' . date('Ymd') . '-' . str_pad(Pengaduan::count() + 1, 3, '0', STR_PAD_LEFT);
        $data['status'] = 'Baru';
        $data['tanggal_pengaduan'] = now();

        // Map request fields to database fields
        $data['pesan'] = $data['deskripsi'];  // deskripsi -> pesan
        unset($data['deskripsi'], $data['alamat'], $data['judul'], $data['lokasi']);  // Remove unmapped fields

        // Handle file upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengaduan'), $filename);
            $data['foto'] = 'uploads/pengaduan/' . $filename;
        }

        $pengaduan = Pengaduan::create($data);

        Log::info('PengaduanApiController: New pengaduan created', [
            'pengaduan_id' => $pengaduan->id,
            'nomor_tiket' => $pengaduan->nomor_tiket,
            'nama' => $pengaduan->nama,
            'email' => $pengaduan->email,
            'kategori' => $pengaduan->kategori
        ]);

        // Send email notification (non-blocking)
        try {
            $emailSent = $this->emailService->sendPengaduanNotification($pengaduan);

            Log::info('PengaduanApiController: Email notification result', [
                'pengaduan_id' => $pengaduan->id,
                'nomor_tiket' => $pengaduan->nomor_tiket,
                'email_sent' => $emailSent
            ]);
        } catch (\Exception $emailError) {
            // Email failure shouldn't block the pengaduan creation
            Log::warning('PengaduanApiController: Email notification failed but pengaduan saved', [
                'pengaduan_id' => $pengaduan->id,
                'nomor_tiket' => $pengaduan->nomor_tiket,
                'email_error' => $emailError->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaduan berhasil dikirim',
            'data' => [
                'id' => $pengaduan->id,
                'nomor_tiket' => $pengaduan->nomor_tiket,
                'status' => $pengaduan->status,
                'created_at' => $pengaduan->created_at
            ]
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pengaduan/{nomor_tiket}",
     *     summary="Cek Status Pengaduan",
     *     tags={"Pengaduan"},
     *     @OA\Parameter(
     *         name="nomor_tiket",
     *         in="path",
     *         description="Nomor tiket pengaduan",
     *         @OA\Schema(type="string", example="TKT-20250909-001")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Status pengaduan berhasil diambil")
     *         )
     *     )
     * )
     */
    public function checkStatus($nomor_tiket)
    {
        $pengaduan = Pengaduan::where('nomor_tiket', $nomor_tiket)->first();

        if (!$pengaduan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengaduan dengan nomor tiket tersebut tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Status pengaduan berhasil diambil',
            'data' => [
                'nomor_tiket' => $pengaduan->nomor_tiket,
                'judul' => $pengaduan->kategori,  // Use kategori as title
                'status' => $pengaduan->status,
                'tanggal_pengaduan' => $pengaduan->created_at->format('Y-m-d'),
                'tanggal_update' => $pengaduan->updated_at,
                'keterangan' => $pengaduan->pesan ?? 'Belum ada keterangan'
            ]
        ]);
    }
}
