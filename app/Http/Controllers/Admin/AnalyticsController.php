<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Video;
use App\Models\Pengaduan;
use App\Models\Ulasan;
use App\Models\FileDownload;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Data statistik untuk dashboard analytics
        $stats = [
            'total_berita' => Berita::count(),
            'total_galeri' => Galeri::count(),
            'total_video' => Video::count(),
            'total_pengaduan' => Pengaduan::count(),
            'total_ulasan' => Ulasan::count(),
            'total_downloads' => FileDownload::sum('download_count'),
        ];

        // Data bulanan untuk chart
        $monthlyData = $this->getMonthlyData();

        // Data pengaduan berdasarkan status
        $pengaduanStats = Pengaduan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // Rating rata-rata
        $avgRating = Ulasan::avg('rating') ?? 0;

        // Video paling populer
        $popularVideos = Video::orderBy('views', 'desc')->take(5)->get();

        // File paling banyak diunduh
        $popularDownloads = FileDownload::orderBy('download_count', 'desc')->take(5)->get();

        return view('admin.analytics.index', compact(
            'stats',
            'monthlyData',
            'pengaduanStats',
            'avgRating',
            'popularVideos',
            'popularDownloads'
        ));
    }

    private function getMonthlyData()
    {
        $months = [];
        $beritaData = [];
        $pengaduanData = [];
        $permohonanData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');

            $beritaData[] = Berita::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $pengaduanData[] = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return [
            'months' => $months,
            'berita' => $beritaData,
            'pengaduan' => $pengaduanData,
        ];
    }

    public function export()
    {
        // Export data analytics ke Excel/PDF
        // Implementasi export bisa ditambahkan nanti
        return response()->json(['message' => 'Export feature coming soon']);
    }
}
