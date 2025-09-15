<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Ulasan form submission attempt', [
                'request_data' => $request->except(['_token']),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Validate input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'instansi' => 'nullable|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'ulasan' => 'required|string|max:1000',
                'kategori' => [
                    'required',
                    'string',
                    Rule::in(['Perizinan', 'Infrastruktur', 'Informasi', 'Konsultasi', 'Pelayanan Umum', 'Lainnya', 'Pelayanan', 'Komunikasi', 'Kecepatan', 'Kualitas', 'Umum'])
                ],
                'rating_pelayanan' => 'nullable|integer|min:1|max:5',
                'rating_kecepatan' => 'nullable|integer|min:1|max:5',
                'rating_kualitas' => 'nullable|integer|min:1|max:5',
                'rating_komunikasi' => 'nullable|integer|min:1|max:5',
            ], [
                'nama.required' => 'Nama lengkap wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'rating.required' => 'Rating wajib dipilih',
                'rating.min' => 'Rating minimal 1 bintang',
                'rating.max' => 'Rating maksimal 5 bintang',
                'ulasan.required' => 'Ulasan wajib diisi',
                'ulasan.max' => 'Ulasan maksimal 1000 karakter',
                'kategori.required' => 'Kategori wajib dipilih',
                'kategori.in' => 'Kategori tidak valid',
            ]);

            DB::beginTransaction();

            // Prepare detailed ratings
            $ratingDetail = [];
            if ($request->filled('rating_pelayanan')) {
                $ratingDetail['pelayanan'] = (int)$request->rating_pelayanan;
            }
            if ($request->filled('rating_kecepatan')) {
                $ratingDetail['kecepatan'] = (int)$request->rating_kecepatan;
            }
            if ($request->filled('rating_kualitas')) {
                $ratingDetail['kualitas'] = (int)$request->rating_kualitas;
            }
            if ($request->filled('rating_komunikasi')) {
                $ratingDetail['komunikasi'] = (int)$request->rating_komunikasi;
            }

            // Create ulasan
            $ulasan = Ulasan::create([
                'nama' => trim($validated['nama']),
                'email' => strtolower(trim($validated['email'])),
                'instansi' => $request->filled('instansi') ? trim($validated['instansi']) : null,
                'rating' => (int)$validated['rating'],
                'ulasan' => trim($validated['ulasan']),
                'kategori' => $validated['kategori'],
                'rating_detail' => !empty($ratingDetail) ? $ratingDetail : null,
                'is_featured' => false, // Admin will decide
                'is_published' => false, // Needs admin approval
            ]);

            DB::commit();

            Log::info('Ulasan created successfully', [
                'id' => $ulasan->id,
                'rating' => $ulasan->rating,
                'kategori' => $ulasan->kategori,
                'has_detail_rating' => !empty($ratingDetail)
            ]);

            return redirect()->back()->with(
                'success',
                'Terima kasih atas ulasan Anda! Ulasan akan ditampilkan setelah diverifikasi oleh admin.'
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Ulasan validation failed', [
                'errors' => $e->errors(),
                'input' => $request->except(['_token'])
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Ulasan creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token'])
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan ulasan. Silakan coba lagi.')
                ->withInput();
        }
    }

    public function getFeaturedReviews()
    {
        try {
            $featuredReviews = Ulasan::where('is_published', true)
                ->where('is_featured', true)
                ->orderBy('rating', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();

            return $featuredReviews;
        } catch (\Exception $e) {
            Log::error('Failed to fetch featured reviews', [
                'error' => $e->getMessage()
            ]);
            return collect(); // Return empty collection on error
        }
    }

    public function getPublicReviews(Request $request)
    {
        try {
            $query = Ulasan::where('is_published', true);

            // Filter by category if provided
            if ($request->filled('kategori') && $request->kategori !== 'Semua') {
                $query->where('kategori', $request->kategori);
            }

            // Filter by rating if provided
            if ($request->filled('rating') && $request->rating > 0) {
                $query->where('rating', '>=', $request->rating);
            }

            // Sort options
            $sortBy = $request->get('sort', 'terbaru');
            switch ($sortBy) {
                case 'rating_tinggi':
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'rating_rendah':
                    $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                default: // terbaru
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $reviews = $query->paginate(12);

            return view('public.ulasan', compact('reviews'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch public reviews', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat ulasan.');
        }
    }
}
