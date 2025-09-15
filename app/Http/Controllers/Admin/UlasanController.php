<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::orderByDesc('created_at')->paginate(10);

        // Statistics
        $stats = [
            'total' => Ulasan::count(),
            'published' => Ulasan::where('is_published', true)->count(),
            'pending' => Ulasan::where('is_published', false)->count(),
            'featured' => Ulasan::where('is_featured', true)->count(),
        ];

        return view('admin.ulasan.index', compact('ulasans', 'stats'));
    }

    public function show(Ulasan $ulasan)
    {
        return view('admin.ulasan.show', compact('ulasan'));
    }

    public function updateStatus(Request $request, Ulasan $ulasan)
    {
        $request->validate([
            'is_published' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $ulasan->update([
            'is_published' => $request->boolean('is_published'),
            'is_featured' => $request->boolean('is_featured')
        ]);

        Log::info('Ulasan status updated', [
            'id' => $ulasan->id,
            'is_published' => $ulasan->is_published,
            'is_featured' => $ulasan->is_featured,
            'admin' => Auth::user()->name
        ]);

        $message = 'Status ulasan berhasil diperbarui.';
        if ($request->boolean('is_published')) {
            $message .= ' Ulasan sekarang ditampilkan di website.';
        } else {
            $message .= ' Ulasan disembunyikan dari website.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();

        Log::info('Ulasan deleted', [
            'id' => $ulasan->id,
            'nama' => $ulasan->nama,
            'admin' => Auth::user()->name
        ]);

        return redirect()->route('admin.ulasan.index')
            ->with('success', 'Ulasan berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,feature,unfeature,delete',
            'selected' => 'required|array|min:1',
            'selected.*' => 'exists:ulasan,id'
        ]);

        $ulasanIds = $request->selected;
        $action = $request->action;

        switch ($action) {
            case 'publish':
                Ulasan::whereIn('id', $ulasanIds)->update(['is_published' => true]);
                $message = count($ulasanIds) . ' ulasan berhasil dipublikasikan.';
                break;
            case 'unpublish':
                Ulasan::whereIn('id', $ulasanIds)->update(['is_published' => false]);
                $message = count($ulasanIds) . ' ulasan berhasil disembunyikan.';
                break;
            case 'feature':
                Ulasan::whereIn('id', $ulasanIds)->update(['is_featured' => true]);
                $message = count($ulasanIds) . ' ulasan berhasil dijadikan unggulan.';
                break;
            case 'unfeature':
                Ulasan::whereIn('id', $ulasanIds)->update(['is_featured' => false]);
                $message = count($ulasanIds) . ' ulasan berhasil dihapus dari unggulan.';
                break;
            case 'delete':
                Ulasan::whereIn('id', $ulasanIds)->delete();
                $message = count($ulasanIds) . ' ulasan berhasil dihapus.';
                break;
        }

        Log::info('Bulk action performed on ulasan', [
            'action' => $action,
            'count' => count($ulasanIds),
            'admin' => Auth::user()->name
        ]);

        return redirect()->back()->with('success', $message);
    }
}
