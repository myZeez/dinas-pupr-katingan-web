<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Program;
use App\Models\Pengaduan;
use App\Models\Ulasan;
use App\Models\Galeri;
use App\Models\Struktur;
use App\Models\PublicContent;
use App\Models\PublicContentNew;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SoftDeletedController extends Controller
{
    /**
     * Display soft deleted items across all models
     */
    public function index(Request $request)
    {
        // Check admin access
        if (!Auth::user() || !Auth::user()->hasAdminAccess()) {
            return redirect()->route('login')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $type = $request->get('type', 'berita');

        $data = [];
        $stats = $this->getSoftDeletedStats();

        switch ($type) {
            case 'berita':
                $data = Berita::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'program':
                $data = Program::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'pengaduan':
                $data = Pengaduan::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'ulasan':
                $data = Ulasan::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'galeri':
                $data = Galeri::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'struktur':
                $data = Struktur::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;

            case 'public_content_news':
                $data = PublicContentNew::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->paginate(10);
                break;
        }

        return view('admin.soft-deleted.index', compact('data', 'type', 'stats'));
    }

    /**
     * Restore a specific item
     */
    public function restore(Request $request, $type, $id)
    {
        try {
            $model = $this->getModel($type);
            $item = $model::onlyTrashed()->findOrFail($id);

            $item->restore();

            Log::info('Item restored from trash', [
                'type' => $type,
                'id' => $id,
                'user_id' => Auth::id(),
                'restored_at' => now()
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Failed to restore item', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back();
        }
    }

    /**
     * Permanently delete an item
     */
    public function forceDelete(Request $request, $type, $id)
    {
        try {
            $model = $this->getModel($type);
            $item = $model::onlyTrashed()->findOrFail($id);

            // Store item data for logging before permanent deletion
            $itemData = $item->toArray();

            $item->forceDelete();

            Log::warning('Item permanently deleted', [
                'type' => $type,
                'id' => $id,
                'data' => $itemData,
                'user_id' => Auth::id(),
                'deleted_at' => now()
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Failed to permanently delete item', [
                'type' => $type,
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back();
        }
    }

    /**
     * Clean up old soft deleted items (older than 30 days)
     */
    public function cleanup(Request $request)
    {
        try {
            $cutoffDate = now()->subDays(30);
            $totalCleaned = 0;

            $models = [
                'berita' => Berita::class,
                'program' => Program::class,
                'pengaduan' => Pengaduan::class,
                'ulasan' => Ulasan::class,
                'galeri' => Galeri::class,
                'struktur' => Struktur::class,
                'public_content_news' => PublicContentNew::class,
            ];

            foreach ($models as $type => $modelClass) {
                $count = $modelClass::onlyTrashed()
                    ->where('deleted_at', '<', $cutoffDate)
                    ->count();

                $modelClass::onlyTrashed()
                    ->where('deleted_at', '<', $cutoffDate)
                    ->forceDelete();

                $totalCleaned += $count;

                Log::info("Cleaned up old {$type} items", [
                    'count' => $count,
                    'cutoff_date' => $cutoffDate
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Cleanup failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back();
        }
    }

    /**
     * Get statistics of soft deleted items
     */
    private function getSoftDeletedStats()
    {
        return [
            'berita' => Berita::onlyTrashed()->count(),
            'program' => Program::onlyTrashed()->count(),
            'pengaduan' => Pengaduan::onlyTrashed()->count(),
            'ulasan' => Ulasan::onlyTrashed()->count(),
            'galeri' => Galeri::onlyTrashed()->count(),
            'struktur' => Struktur::onlyTrashed()->count(),
            'public_content_news' => PublicContentNew::onlyTrashed()->count(),
        ];
    }

    /**
     * Get model class by type
     */
    private function getModel($type)
    {
        $models = [
            'berita' => Berita::class,
            'program' => Program::class,
            'pengaduan' => Pengaduan::class,
            'ulasan' => Ulasan::class,
            'galeri' => Galeri::class,
            'struktur' => Struktur::class,
            'public_content_news' => PublicContentNew::class,
        ];

        if (!isset($models[$type])) {
            throw new \InvalidArgumentException("Invalid model type: {$type}");
        }

        return $models[$type];
    }
}
