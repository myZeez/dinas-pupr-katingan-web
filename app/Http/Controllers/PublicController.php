<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Program;
use App\Models\PublicContent;
use App\Models\PublicContentNew;
use App\Models\Galeri;
use App\Models\Pengaduan;
use App\Models\Ulasan;
use App\Models\FileDownload;
use App\Models\Video;
use App\Models\Struktur;
use App\Models\Profil;
use App\Models\User;
use App\Mail\KontakNotification;
use App\Services\SimpleCaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    public function home()
    {
        // Get profil data for About section
        $profil = Profil::first();

        // Get existing data
        $latestBerita = Berita::latest()->take(3)->get();
        $latestProgram = Program::latest()->take(3)->get();

        // Calculate real statistics from database
        $totalProgram = Program::count();
        $programBerjalan = Program::where('status', 'Berjalan')->count();
        $totalBerita = Berita::count();
        $totalPengaduan = Pengaduan::count();
        $totalStaffAktif = Struktur::count(); // Updated to use Struktur model
        $totalStruktur = Struktur::count(); // Updated to use Struktur model

        // Get public content data from PublicContentNew
        $carouselSlides = PublicContentNew::where('tipe', 'karousel')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        // Untuk sementara, stats counter tidak ada di public_content_news
        // Bisa dibuat data dummy atau dihapus jika tidak digunakan
        $statsCounters = collect([]);

        $heroVideo = PublicContentNew::where('tipe', 'video')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->first();

        $partnerLogos = PublicContentNew::where('tipe', 'mitra')
            ->where('status', 'aktif')
            ->orderBy('urutan')
            ->get();

        // Get hero video from Video model
        $heroVideoFromModel = Video::aktif()
            ->hero()
            ->orderBy('created_at', 'desc')
            ->first();

        // Untuk sementara, testimonial dan announcement tidak ada di public_content_news
        // Bisa dibuat data dummy atau dihapus jika tidak digunakan
        $testimonials = collect([]);

        $announcements = collect([]);

        // Get top 3 published reviews with highest ratings
        $topUlasan = Ulasan::where('is_published', true)
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // Get latest gallery items for homepage
        $latestGaleri = Galeri::aktif()
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('public.home', compact(
            'profil',
            'latestBerita',
            'latestProgram',
            'totalProgram',
            'programBerjalan',
            'totalBerita',
            'totalPengaduan',
            'totalStaffAktif',
            'totalStruktur',
            'carouselSlides',
            'statsCounters',
            'heroVideo',
            'heroVideoFromModel',
            'partnerLogos',
            'testimonials',
            'announcements',
            'topUlasan',
            'latestGaleri'
        ));
    }

    public function berita()
    {
        $beritas = Berita::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        return view('public.berita.index', compact('beritas'));
    }

    public function beritaShow($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
        $relatedBerita = Berita::where('id', '!=', $berita->id)
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        return view('public.berita-detail', compact('berita', 'relatedBerita'));
    }

    public function program()
    {
        $programs = Program::orderBy('created_at', 'desc')->paginate(9);
        return view('public.program', compact('programs'));
    }

    public function programShow($id)
    {
        $program = Program::findOrFail($id);
        $relatedPrograms = Program::where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.program-detail', compact('program', 'relatedPrograms'));
    }

    public function galeri()
    {
        $galeris = Galeri::aktif()->orderBy('created_at', 'desc')->paginate(12);

        // Get statistics data separately for better performance
        $totalGaleris = Galeri::aktif()->count();
        $monthlyCount = Galeri::aktif()->where('created_at', '>=', now()->startOfMonth())->count();
        $weeklyCount = Galeri::aktif()->where('created_at', '>=', now()->startOfWeek())->count();
        $totalViews = Galeri::aktif()->sum('views') ?? 0;

        return view('public.galeri', compact('galeris', 'totalGaleris', 'monthlyCount', 'weeklyCount', 'totalViews'));
    }

    public function struktur()
    {
        // Group struktur berdasarkan jabatan dan urutkan berdasarkan hierarki
        $jabatanHierarki = [
            'Kepala Dinas',
            'Sekretaris',
            'Kepala Subbagian Umum dan Kepegawaian',
            'Kepala Subbagian Keuangan, Perencanaan, Evaluasi dan Pelaporan',
            'Kepala Bidang Bina Marga',
            'Kepala Seksi Pembangunan Jalan dan Jembatan',
            'Kepala Seksi Pemeliharaan Jalan dan Jembatan',
            'Kepala Seksi Perencanaan Teknik Jalan dan Jembatan',
            'Kepala Bidang Cipta Karya',
            'Kepala Seksi Perumahan dan Permukiman',
            'Kepala Seksi Bangunan Gedung',
            'Kepala Seksi Penyehatan Lingkungan Permukiman',
            'Kepala Bidang Tata Ruang dan Bina Konstruksi',
            'Kepala Seksi Penataan Ruang',
            'Kepala Seksi Pengendalian Pemanfaatan Ruang',
            'Kepala Seksi Bina Konstruksi',
            'Kepala Bidang Sumber Daya Air',
            'Kepala Seksi Irigasi dan Rawa',
            'Kepala Seksi Sungai, Pantai dan Drainase',
            'Kepala Seksi Bina Operasi dan Pemeliharaan',
            'Staff IT dan Sistem Informasi',
            'Staff Administrasi',
            'Staff Keuangan'
        ];

        // Ambil semua struktur dan kelompokkan berdasarkan jabatan
        $allStruktur = Struktur::with('pltStruktur')
            ->where('status', 'aktif')
            ->orderBy('urutan', 'asc')
            ->get();

        // Kelompokkan dan urutkan berdasarkan hierarki yang telah ditentukan
        $strukturByJabatan = collect();

        foreach ($jabatanHierarki as $jabatan) {
            $anggota = $allStruktur->where('jabatan', $jabatan);
            if ($anggota->count() > 0) {
                $strukturByJabatan->push([
                    'jabatan' => $jabatan,
                    'anggota' => $anggota->values()
                ]);
            }
        }

        // Tambahkan jabatan yang tidak ada dalam hierarki (jika ada)
        $jabatanTerdaftar = collect($jabatanHierarki);
        $jabatanLainnya = $allStruktur->pluck('jabatan')->unique()->diff($jabatanTerdaftar);

        foreach ($jabatanLainnya as $jabatan) {
            $anggota = $allStruktur->where('jabatan', $jabatan);
            $strukturByJabatan->push([
                'jabatan' => $jabatan,
                'anggota' => $anggota->values()
            ]);
        }

        $totalAnggota = $allStruktur->count();
        $totalJabatan = $strukturByJabatan->count();

        return view('public.profil.struktur', compact('strukturByJabatan', 'totalAnggota', 'totalJabatan'));
    }

    public function profil()
    {
        // Data profil dinas
        $profil = Profil::first();

        // Data struktural berdasarkan hierarki
        $hierarki = Struktur::where('status', 'aktif')->get();

        // Data visi, misi, tupoksi (ambil dari struktur atau model terpisah jika ada)
        $visi = collect([
            (object)[
                'judul' => 'Visi Dinas PUPR',
                'deskripsi' => 'Terwujudnya infrastruktur yang berkualitas dan berkelanjutan di Kabupaten Katingan'
            ]
        ])->first();

        $misi = collect([
            (object)['deskripsi' => 'Meningkatkan kualitas infrastruktur jalan dan jembatan'],
            (object)['deskripsi' => 'Mengembangkan infrastruktur permukiman yang layak'],
            (object)['deskripsi' => 'Menata ruang yang optimal dan berkelanjutan'],
            (object)['deskripsi' => 'Mengelola sumber daya air secara efektif']
        ]);

        $tupoksi = collect([
            (object)['deskripsi' => 'Pembangunan dan pemeliharaan infrastruktur jalan'],
            (object)['deskripsi' => 'Penataan ruang dan wilayah'],
            (object)['deskripsi' => 'Pengelolaan sumber daya air'],
            (object)['deskripsi' => 'Pengawasan konstruksi bangunan']
        ]);

        // Data galeri/kegiatan untuk carousel
        $carousel = Galeri::aktif()->orderBy('created_at', 'desc')->take(5)->get();

        // Data video profil
        $videos = PublicContentNew::where('tipe', 'video')
            ->where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.profil.index', compact(
            'profil',
            'hierarki',
            'visi',
            'misi',
            'tupoksi',
            'carousel',
            'videos'
        ));
    }

    public function profilKonten()
    {
        $carousel = Galeri::where('status', 'aktif')->orderBy('created_at', 'desc')->get();
        $videos = PublicContentNew::where('tipe', 'video')->where('status', 'aktif')->orderBy('created_at', 'desc')->get();
        $galeris = Galeri::where('status', 'aktif')->orderBy('created_at', 'desc')->paginate(12);
        $fileDownloads = FileDownload::where('status', 'aktif')->orderBy('created_at', 'desc')->paginate(10);
        $mitra = PublicContentNew::where('tipe', 'mitra')->where('status', 'aktif')->orderBy('urutan', 'asc')->get();
        $files = FileDownload::where('status', 'aktif')->orderBy('created_at', 'desc')->get();

        return view('public.profil.konten', compact('carousel', 'videos', 'galeris', 'fileDownloads', 'mitra', 'files'));
    }

    public function pengaduan()
    {
        return view('public.pengaduan');
    }

    public function pengaduanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
            'kategori' => 'required|string|in:infrastruktur,layanan,lainnya'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Pengaduan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'subjek' => $request->judul,  // FIXED: Map judul to subjek column
            'pesan' => $request->pesan,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pengaduan Anda berhasil dikirim. Terima kasih!');
    }

    public function ulasan()
    {
        $ulasan = Ulasan::where('is_published', true)
            ->orderByDesc('rating')
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('public.ulasan', compact('ulasan'));
    }

    public function ulasanStore(Request $request)
    {
        // Simple CAPTCHA verification
        $captchaService = new SimpleCaptchaService();
        if ($captchaService->isRequired()) {
            if (!$captchaService->verify($request)) {
                return back()->withErrors(['captcha' => 'Jawaban CAPTCHA salah. Silakan coba lagi.'])->withInput();
            }
        }

        // Handle both old form fields and new form fields
        $isNewForm = $request->has('review_nama');

        if ($isNewForm) {
            // New form from contact page - merge validation rules
            $validationRules = array_merge([
                'review_nama' => 'required|string|max:255',
                'review_email' => 'required|email|max:255',
                'review_telepon' => 'nullable|string|max:20',
                'layanan' => 'required|string|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'review_pesan' => 'required|string|min:10',
            ], $captchaService->getValidationRules());

            $validationMessages = array_merge([
                'review_nama.required' => 'Nama lengkap harus diisi.',
                'review_email.required' => 'Email harus diisi.',
                'review_email.email' => 'Format email tidak valid.',
                'layanan.required' => 'Silakan pilih layanan yang digunakan.',
                'rating.required' => 'Silakan berikan rating.',
                'rating.min' => 'Rating minimal 1 bintang.',
                'rating.max' => 'Rating maksimal 5 bintang.',
                'review_pesan.required' => 'Ulasan harus diisi.',
                'review_pesan.min' => 'Ulasan minimal 10 karakter.',
            ], $captchaService->getValidationMessages());

            $validator = Validator::make($request->all(), $validationRules, $validationMessages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            Ulasan::create([
                'nama' => $request->review_nama,
                'email' => $request->review_email,
                'rating' => $request->rating,
                'ulasan' => $request->review_pesan,
                'kategori' => $request->layanan,
                'is_published' => false,
            ]);

            return back()->with('review_success', 'Ulasan Anda berhasil dikirim dan sedang dalam proses moderasi. Terima kasih!');
        } else {
            // Old form from ulasan page - merge validation rules
            $validationRules = array_merge([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'komentar' => 'required|string|max:1000',
            ], $captchaService->getValidationRules());

            $validationMessages = $captchaService->getValidationMessages();

            $validator = Validator::make($request->all(), $validationRules, $validationMessages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            Ulasan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'rating' => $request->rating,
                'ulasan' => $request->komentar,
                'is_published' => false,
            ]);

            return back()->with('success', 'Ulasan Anda berhasil dikirim dan akan ditampilkan setelah diverifikasi. Terima kasih!');
        }
    }

    public function fileDownload()
    {
        $files = FileDownload::aktif()->orderBy('created_at', 'desc')->paginate(10);
        return view('public.file-download', compact('files'));
    }

    public function downloadFile($id)
    {
        $file = FileDownload::aktif()->findOrFail($id);

        // Increment download count
        $file->increment('download_count');

        $filePath = storage_path('app/' . $file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, $file->nama_file);
    }

    public function video()
    {
        $videos = Video::aktif()->orderBy('created_at', 'desc')->paginate(12);
        return view('public.video', compact('videos'));
    }

    public function videoShow($id)
    {
        $video = Video::aktif()->findOrFail($id);
        $relatedVideos = Video::aktif()
            ->where('id', '!=', $id)
            ->latest()
            ->take(6)
            ->get();

        return view('public.video-detail', compact('video', 'relatedVideos'));
    }

    // Layanan feature removed (layanan() and layananForm() deleted)

    public function unduhan()
    {
        $fileDownloads = FileDownload::aktif()->orderBy('created_at', 'desc')->paginate(10);

        // Get statistics data separately for better performance
        $totalFiles = FileDownload::aktif()->count();
        $pdfCount = FileDownload::aktif()->where('file_type', 'pdf')->count();
        $docCount = FileDownload::aktif()->whereIn('file_type', ['doc', 'docx'])->count();
        $totalDownloads = FileDownload::aktif()->sum('download_count') ?? 0;

        return view('public.unduhan', compact('fileDownloads', 'totalFiles', 'pdfCount', 'docCount', 'totalDownloads'));
    }

    public function kontak()
    {
        $profil = Profil::getOrCreateDefault();
        return view('public.kontak', compact('profil'));
    }

    public function kontakStore(Request $request)
    {
        // Simple CAPTCHA verification
        $captchaService = new SimpleCaptchaService();
        if ($captchaService->isRequired()) {
            if (!$captchaService->verify($request)) {
                return back()->withErrors(['captcha' => 'Jawaban CAPTCHA salah. Silakan coba lagi.'])->withInput();
            }
        }

        // Merge captcha validation rules
        $validationRules = array_merge([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string',
        ], $captchaService->getValidationRules());

        $validationMessages = array_merge([
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'subjek.required' => 'Subjek harus diisi.',
            'pesan.required' => 'Pesan harus diisi.',
        ], $captchaService->getValidationMessages());

        $validator = Validator::make($request->all(), $validationRules, $validationMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Save to database (pengaduan table)
        try {
            // Generate nomor tiket
            $nomorTiket = 'TKT-' . date('Ymd') . '-' . str_pad(Pengaduan::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

            Pengaduan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telepon' => $request->telepon,
                'kategori' => $request->subjek,  // FIXED: Map subjek to kategori column
                'pesan' => $request->pesan,
                'status' => 'Baru',  // FIXED: Use correct enum value
                'nomor_tiket' => $nomorTiket
            ]);

            Log::info('Contact form data saved to database', [
                'nama' => $request->nama,
                'email' => $request->email,
                'kategori' => $request->subjek,  // FIXED: Log kategori, not subjek
                'nomor_tiket' => $nomorTiket,
                'timestamp' => now()
            ]);
        } catch (\Exception $dbError) {
            Log::error('Failed to save contact data to database', [
                'error' => $dbError->getMessage(),
                'data' => $request->all()
            ]);
            return back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.')->withInput();
        }

        // Send email notification to admin
        try {
            $kontakData = [
                'nama' => $request->nama,
                'email' => $request->email,
                'subjek' => $request->subjek,
                'pesan' => $request->pesan,
                'telepon' => $request->telepon
            ];

            $this->sendSimpleKontakNotification($kontakData);
        } catch (\Exception $mailError) {
            Log::error('Failed to send contact notification email', [
                'error' => $mailError->getMessage()
            ]);
            // Don't fail the request if email fails, just log it
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim dan disimpan. Terima kasih!');
    }

    /**
     * Get admin email addresses for notifications
     */
    private function getAdminEmails()
    {
        try {
            // Get admin and super admin users
            $adminEmails = User::whereIn('role', ['admin', 'super_admin'])
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->unique()
                ->values()
                ->toArray();

            // Filter out invalid email formats
            $validEmails = array_filter($adminEmails, function ($email) {
                $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);
                if (!$isValid) {
                    Log::warning('Invalid admin email format found', ['email' => $email]);
                }
                return $isValid;
            });

            // Log found admin emails
            Log::info('Admin emails retrieved', [
                'total_found' => count($adminEmails),
                'valid_emails' => count($validEmails),
                'emails' => array_values($validEmails)
            ]);

            // Fallback to default admin email if no admin users found
            if (empty($validEmails)) {
                $fallbackEmails = [
                    env('ADMIN_EMAIL', 'admin@puprkatingan.go.id'),
                    'info@puprkatingan.go.id'
                ];

                $validFallbacks = array_filter($fallbackEmails, function ($email) {
                    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                });

                Log::warning('Using fallback emails', ['fallback_emails' => $validFallbacks]);
                return $validFallbacks;
            }

            return array_values($validEmails);
        } catch (\Exception $e) {
            Log::error('Error getting admin emails', [
                'error' => $e->getMessage()
            ]);

            // Return fallback emails
            return [
                env('ADMIN_EMAIL', 'admin@puprkatingan.go.id')
            ];
        }
    }

    /**
     * Send email with fallback to log driver if SMTP fails
     */
    private function sendEmailWithFallback($adminEmails, $mailable, $relatedId = null)
    {
        $originalDriver = config('mail.default');
        $emailsSent = [];
        $emailsFailed = [];

        foreach ($adminEmails as $adminEmail) {
            try {
                // Try sending with current mail driver (probably SMTP)
                config(['mail.default' => $originalDriver]);

                Mail::to($adminEmail)->send($mailable);
                $emailsSent[] = $adminEmail;

                Log::info('Email sent successfully via ' . $originalDriver, [
                    'to' => $adminEmail,
                    'related_id' => $relatedId,
                    'driver' => $originalDriver
                ]);
            } catch (\Exception $smtpError) {
                Log::warning('SMTP email failed, trying log fallback', [
                    'to' => $adminEmail,
                    'related_id' => $relatedId,
                    'smtp_error' => $smtpError->getMessage()
                ]);

                try {
                    // Fallback to log driver
                    config(['mail.default' => 'log']);

                    Mail::to($adminEmail)->send($mailable);
                    $emailsFailed[] = $adminEmail . ' (logged)';

                    Log::info('Email logged successfully as fallback', [
                        'to' => $adminEmail,
                        'related_id' => $relatedId,
                        'original_error' => $smtpError->getMessage()
                    ]);
                } catch (\Exception $logError) {
                    $emailsFailed[] = $adminEmail . ' (completely failed)';
                    Log::error('Both SMTP and log email failed', [
                        'to' => $adminEmail,
                        'related_id' => $relatedId,
                        'smtp_error' => $smtpError->getMessage(),
                        'log_error' => $logError->getMessage()
                    ]);
                }
            }
        }

        // Restore original mail driver
        config(['mail.default' => $originalDriver]);

        // Log summary
        if (!empty($emailsSent)) {
            Log::info('Contact notification emails sent successfully', [
                'related_id' => $relatedId,
                'emails_sent' => $emailsSent
            ]);
        }

        if (!empty($emailsFailed)) {
            Log::warning('Some contact notification emails failed', [
                'related_id' => $relatedId,
                'emails_failed' => $emailsFailed
            ]);
        }

        return [
            'sent' => $emailsSent,
            'failed' => $emailsFailed
        ];
    }

    /**
     * Send simple kontak notification - Laravel style
     */
    private function sendSimpleKontakNotification($kontakData)
    {
        try {
            // Get admin emails
            $adminEmails = $this->getAdminEmails();

            if (empty($adminEmails)) {
                Log::warning('No admin emails found for kontak notification');
                return;
            }

            // Prepare email content
            $subject = "💬 Pesan Kontak Baru: {$kontakData['subjek']}";

            // HTML Content
            $htmlContent = $this->getKontakEmailHtmlContent($kontakData);

            // Text Content (fallback)
            $textContent = $this->getKontakEmailTextContent($kontakData);

            // Track success/failure
            $emailsSent = [];
            $emailsFailed = [];

            // Send to each admin individually
            foreach ($adminEmails as $email) {
                $result = $this->sendKontakToAdmin($email, $subject, $htmlContent, $textContent);
                if ($result) {
                    $emailsSent[] = $email;
                } else {
                    $emailsFailed[] = $email;
                }
            }

            // Log results
            if (!empty($emailsSent)) {
                Log::info('Kontak notification emails sent successfully', [
                    'from_email' => $kontakData['email'],
                    'emails_sent' => $emailsSent
                ]);
            }

            if (!empty($emailsFailed)) {
                Log::warning('Some kontak notification emails failed', [
                    'from_email' => $kontakData['email'],
                    'emails_failed' => $emailsFailed
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Kontak email notification failed', [
                'from_email' => $kontakData['email'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send kontak email to single admin with fallback
     */
    private function sendKontakToAdmin($email, $subject, $htmlContent, $textContent)
    {
        try {
            // Validate email format first
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invalid email format, skipping', ['email' => $email]);
                return false;
            }

            // Try SMTP first
            Mail::send([], [], function ($message) use ($email, $subject, $htmlContent) {
                $message->to($email)
                    ->subject($subject)
                    ->from(config('mail.from.address'), 'PUPR Katingan')
                    ->html($htmlContent);
            });

            Log::info('Kontak email sent via SMTP', ['to' => $email]);
            return true;
        } catch (\Exception $e) {
            // Log specific SMTP error
            Log::warning('SMTP failed for kontak email', [
                'to' => $email,
                'smtp_error' => $e->getMessage()
            ]);

            // SMTP failed, use log fallback
            try {
                $originalDriver = config('mail.default');
                config(['mail.default' => 'log']);

                Mail::raw($textContent, function ($mail) use ($email, $subject) {
                    $mail->to($email)->subject($subject);
                });

                config(['mail.default' => $originalDriver]);

                Log::info('Kontak email fallback to log', [
                    'to' => $email,
                    'smtp_error' => $e->getMessage()
                ]);

                return true; // Log fallback is considered success

            } catch (\Exception $e2) {
                Log::error('All kontak email methods failed', [
                    'to' => $email,
                    'smtp_error' => $e->getMessage(),
                    'log_error' => $e2->getMessage()
                ]);

                return false;
            }
        }
    }

    /**
     * Get HTML email content for kontak
     */
    private function getKontakEmailHtmlContent($kontakData)
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8f9fa;'>
            <div style='background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #17a2b8; margin-bottom: 20px; text-align: center; border-bottom: 3px solid #17a2b8; padding-bottom: 15px;'>
                    💬 PESAN KONTAK BARU
                </h2>

                <div style='background-color: #e1f7f9; padding: 15px; border-radius: 5px; margin-bottom: 20px;'>
                    <h3 style='color: #17a2b8; margin: 0;'>PUPR KATINGAN</h3>
                    <p style='color: #666; margin: 5px 0 0 0;'>Sistem Kontak Online</p>
                </div>

                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold; width: 25%;'>Nama</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>{$kontakData['nama']}</td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Email</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>
                            <a href='mailto:{$kontakData['email']}' style='color: #007bff; text-decoration: none;'>{$kontakData['email']}</a>
                        </td>
                    </tr>
                    <tr style='background-color: #f8f9fa;'>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Subjek</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'><strong>{$kontakData['subjek']}</strong></td>
                    </tr>
                    <tr>
                        <td style='padding: 12px; border: 1px solid #dee2e6; font-weight: bold;'>Waktu</td>
                        <td style='padding: 12px; border: 1px solid #dee2e6;'>" . now()->format('d F Y, H:i') . " WIB</td>
                    </tr>
                </table>

                <div style='margin: 25px 0;'>
                    <h3 style='color: #17a2b8; margin-bottom: 10px;'>📝 Isi Pesan:</h3>
                    <div style='background-color: #ffffff; border: 1px solid #dee2e6; border-left: 5px solid #17a2b8; padding: 20px; border-radius: 5px; white-space: pre-wrap; line-height: 1.6;'>
                        {$kontakData['pesan']}
                    </div>
                </div>

                <div style='text-align: center; margin: 30px 0;'>
                    <a href='mailto:{$kontakData['email']}'
                       style='background: linear-gradient(135deg, #17a2b8, #20c997); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; display: inline-block; font-weight: bold; box-shadow: 0 4px 15px rgba(23,162,184,0.3);'>
                        📧 Balas via Email
                    </a>
                </div>

                <div style='background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 30px; text-align: center;'>
                    <p style='color: #666; font-size: 14px; margin: 0;'>
                        💬 Pesan kontak otomatis dari <strong>Sistem PUPR Katingan</strong><br>
                        Balas langsung ke email pengirim untuk merespon
                    </p>
                </div>
            </div>
        </div>";
    }

    /**
     * Get text email content for kontak (fallback)
     */
    private function getKontakEmailTextContent($kontakData)
    {
        return "
💬 PESAN KONTAK BARU - PUPR KATINGAN
===================================

INFORMASI PENGIRIM:
- Nama: {$kontakData['nama']}
- Email: {$kontakData['email']}
- Subjek: {$kontakData['subjek']}
- Waktu: " . now()->format('d F Y, H:i') . " WIB

ISI PESAN:
{$kontakData['pesan']}

===================================
Untuk membalas, kirim email ke: {$kontakData['email']}

Pesan kontak otomatis dari sistem PUPR Katingan
        ";
    }
}
