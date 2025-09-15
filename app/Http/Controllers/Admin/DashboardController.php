<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Program;
use App\Models\Ulasan;
use App\Models\Pengaduan;
use App\Models\Galeri;
use App\Models\Struktur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate real statistics from database
        $totalBerita = Berita::count();
        $totalProgram = Program::count();
        $totalPengaduan = Pengaduan::count();
        $totalUlasan = Ulasan::count();
        $ulasanPublished = Ulasan::where('is_published', true)->count();
        $pengaduanBaru = Pengaduan::where('status', 'pending')->count();
        $programBerjalan = Program::where('status', 'Berjalan')->count();
        $totalStaffAktif = Struktur::where('status', 'aktif')->count();

        // Calculate percentage changes (comparing to last month)
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $beritaLastMonth = Berita::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();
        $beritaCurrentMonth = Berita::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();
        $beritaPercentage = $beritaLastMonth > 0 ? round((($beritaCurrentMonth - $beritaLastMonth) / $beritaLastMonth) * 100) : 0;

        $programLastMonth = Program::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();
        $programCurrentMonth = Program::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();
        $programPercentage = $programLastMonth > 0 ? round((($programCurrentMonth - $programLastMonth) / $programLastMonth) * 100) : 0;

        // Get monthly data for chart (last 12 months)
        $monthlyBerita = [];
        $monthlyProgram = [];
        $monthLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M');

            $beritaCount = Berita::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyBerita[] = $beritaCount;

            $programCount = Program::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $monthlyProgram[] = $programCount;
        }

        // Calculate soft deleted stats
        $softDeletedStats = [
            'berita' => Berita::onlyTrashed()->count(),
            'program' => Program::onlyTrashed()->count(),
            'pengaduan' => Pengaduan::onlyTrashed()->count(),
            'ulasan' => Ulasan::onlyTrashed()->count(),
            'galeri' => Galeri::onlyTrashed()->count(),
            'struktur' => Struktur::onlyTrashed()->count(),
        ];
        $totalSoftDeleted = array_sum($softDeletedStats);

        // Admin statistics (only for Super Admin)
        $adminStats = null;
        if (Auth::user()->isSuperAdmin()) {
            $adminStats = [
                'totalAdmins' => User::where('role', 'admin')->count(),
                'superAdmins' => User::where('role', 'super_admin')->count(),
                'activeAdmins' => User::where('role', 'admin')->where('status', 'active')->count(),
                'inactiveAdmins' => User::where('role', 'admin')->where('status', 'inactive')->count(),
                'newAdminsThisMonth' => User::where('role', 'admin')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->count(),
                'recentLogins' => User::whereIn('role', ['admin', 'super_admin'])
                    ->whereNotNull('last_login_at')
                    ->where('last_login_at', '>=', Carbon::now()->subDays(7))
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'totalBerita',
            'totalProgram',
            'totalPengaduan',
            'totalUlasan',
            'ulasanPublished',
            'totalStaffAktif',
            'pengaduanBaru',
            'programBerjalan',
            'beritaPercentage',
            'programPercentage',
            'monthlyBerita',
            'monthlyProgram',
            'monthLabels',
            'softDeletedStats',
            'totalSoftDeleted',
            'adminStats'
        ));
    }
}
