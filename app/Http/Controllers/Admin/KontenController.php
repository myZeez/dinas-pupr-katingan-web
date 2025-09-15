<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\FileDownload;
use App\Models\Berita;
use App\Models\KontenPublic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KontenController extends Controller
{
    /**
     * Display integrated content page with berita, galeri and file download tabs
     */
    public function index(Request $request)
    {
        // Data untuk Berita
        $beritas = Berita::orderBy('created_at', 'desc')->paginate(12, ['*'], 'berita_page');

        // Data untuk Galeri
        $galeris = Galeri::orderBy('created_at', 'desc')->paginate(12, ['*'], 'galeri_page');

        // Data untuk File Download
        $fileDownloads = FileDownload::orderBy('created_at', 'desc')->paginate(12, ['*'], 'download_page');

        // Data untuk Konten Public
        $kontenPublics = KontenPublic::orderBy('urutan')->get();

        // Statistics
        $beritaCount = Berita::count();
        $galeriCount = Galeri::count();
        $downloadCount = FileDownload::count();
        $kontenPublicCount = KontenPublic::count();
        $totalDownloads = FileDownload::sum('download_count');

        // Recent activity
        $recentBeritas = Berita::latest()->take(5)->get();
        $recentGaleris = Galeri::latest()->take(5)->get();
        $recentDownloads = FileDownload::latest()->take(5)->get();
        $popularDownloads = FileDownload::orderBy('download_count', 'desc')->take(5)->get();

        return view('admin.konten.index', compact(
            'beritas',
            'galeris',
            'fileDownloads',
            'kontenPublics',
            'beritaCount',
            'galeriCount',
            'downloadCount',
            'kontenPublicCount',
            'totalDownloads',
            'recentBeritas',
            'recentGaleris',
            'recentDownloads',
            'popularDownloads'
        ));
    }
    /**
     * Show file download creation form
     */
    public function createDownload()
    {
        return view('admin.konten.download.create');
    }

    /**
     * Store new file download
     */
    public function storeDownload(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'kategori' => 'required|in:dokumen,formulir,peraturan,panduan,infrastruktur,perencanaan,pembangunan,pemeliharaan,monitoring,lainnya'
        ]);

        $data = [
            'nama_file' => $request->judul, // Map judul to nama_file
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'status' => 'aktif', // Default status
            'urutan' => 0, // Default urutan
            'download_count' => 0,
            'user_id' => Auth::id()
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('downloads', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
            $data['file_type'] = $file->getMimeType();
        }

        try {
            $fileDownload = FileDownload::create($data);

            // Log activity if ActivityLog class exists
            if (class_exists('App\Models\ActivityLog')) {
                \App\Models\ActivityLog::log('create', $fileDownload, 'Menambah file download: ' . $fileDownload->nama_file);
            }

            return redirect()->route('admin.konten.index', ['tab' => 'download'])
                ->with('success', 'File download berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating file download: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan file download: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show berita creation form
     */

    // ===== BERITA MANAGEMENT METHODS =====

    /**
     * Show form for creating new berita with modern interface
     */
    public function createBerita()
    {
        return view('admin.konten.berita.create');
    }

    /**
     * Show test form for debugging berita creation
     */
    public function testBerita()
    {
        return view('admin.konten.berita.test');
    }

    /**
     * Store new berita with enhanced validation and features
     */
    public function storeBerita(Request $request)
    {
        // Write to file for debugging
        file_put_contents(
            storage_path('logs/debug.log'),
            date('Y-m-d H:i:s') . " - Store Berita Called - Data: " . json_encode($request->all()) . "\n",
            FILE_APPEND | LOCK_EX
        );

        try {
            // Debug: Log incoming request
            Log::info('Berita Store Request', [
                'method' => $request->method(),
                'data' => $request->all()
            ]);

            // Enhanced validation with custom messages
            $validated = $request->validate([
                'judul' => 'required|string|max:255|min:10',
                'ringkasan' => 'required|string|max:500',
                'konten' => 'required|string|min:100',
                'kategori' => 'required|string|in:umum,infrastruktur,bina-marga,sumber-daya-air,cipta-karya,tata-ruang',
                'tags' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'tanggal' => 'required|date',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'status' => 'required|in:draft,published',
                'featured' => 'nullable|boolean',
                'tanggal_publikasi' => 'nullable|date'
            ], [
                'judul.min' => 'Judul minimal 10 karakter',
                'konten.min' => 'Konten minimal 100 karakter',
                'ringkasan.max' => 'Ringkasan maksimal 500 karakter',
                'tanggal.required' => 'Tanggal berita wajib diisi',
                'thumbnail.max' => 'Ukuran gambar maksimal 2MB',
                'status.required' => 'Status publikasi harus dipilih'
            ]);

            Log::info('Validation passed', $validated);

            // Auto-generate unique slug
            $slug = $this->generateUniqueSlug($validated['judul']);

            // Prepare data
            $data = [
                'judul' => $validated['judul'],
                'slug' => $slug,
                'konten' => $validated['konten'],
                'author' => $validated['author'] ?? Auth::user()->name,
                'tanggal' => $validated['tanggal'],
                'status' => $validated['status'],
                'tanggal_publikasi' => $validated['status'] === 'published' ? now() : null,
            ];

            // Add optional fields only if they exist in database
            if (isset($validated['ringkasan'])) {
                $data['ringkasan'] = $validated['ringkasan'];
            }
            if (isset($validated['kategori'])) {
                $data['kategori'] = $validated['kategori'];
            }
            if (isset($validated['tags'])) {
                $data['tags'] = $validated['tags'];
            }
            if ($request->has('featured')) {
                $data['featured'] = $request->boolean('featured');
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . Str::slug($validated['judul']) . '.' . $file->getClientOriginalExtension();
                $data['thumbnail'] = $file->storeAs('berita', $filename, 'public');
            }

            Log::info('Data to be saved', $data);

            // Create berita
            $berita = Berita::create($data);

            Log::info('Berita created successfully', ['id' => $berita->id]);

            return redirect()->route('admin.konten.index', ['tab' => 'berita'])
                ->with('success', 'Berita "' . $berita->judul . '" berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Berita Store Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Generate unique slug for berita
     */
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Berita::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
