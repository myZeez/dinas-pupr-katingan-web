<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicContentNew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicContentController extends Controller
{
    /**
     * Display a listing of public content (carousel, video, mitra)
     */
    public function index()
    {
        // Ambil data dari table public_content_news berdasarkan tipe menggunakan Eloquent
        $karousels = PublicContentNew::where('tipe', 'karousel')
            ->orderBy('urutan')
            ->get();

        $videos = PublicContentNew::where('tipe', 'video')
            ->orderBy('created_at', 'desc')
            ->get();

        $mitras = PublicContentNew::where('tipe', 'mitra')
            ->orderBy('urutan')
            ->get();

        return view('admin.public-content.index', compact('karousels', 'videos', 'mitras'));
    }

    /**
     * Display soft deleted content
     */
    public function trashed()
    {
        $trashedContent = PublicContentNew::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.public-content.trashed', compact('trashedContent'));
    }

    /**
     * Restore soft deleted content
     */
    public function restore($id)
    {
        $content = PublicContentNew::onlyTrashed()->find($id);

        if (!$content) {
            return redirect()->back()->with('error', 'Konten tidak ditemukan!');
        }

        $content->restore();

        return redirect()->back()->with('success', 'Konten berhasil dikembalikan!');
    }

    /**
     * Permanently delete content
     */
    public function forceDelete($id)
    {
        $content = PublicContentNew::onlyTrashed()->find($id);

        if (!$content) {
            return redirect()->back()->with('error', 'Konten tidak ditemukan!');
        }

        // Hapus file fisik jika ada
        if ($content->file_path && Storage::exists('public/' . $content->file_path)) {
            Storage::delete('public/' . $content->file_path);
        }

        // Hapus permanen dari database
        $content->forceDelete();

        return redirect()->back()->with('success', 'Konten berhasil dihapus permanen!');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        // Force PHP settings untuk upload besar
        ini_set('upload_max_filesize', '2G');
        ini_set('post_max_size', '2G');
        ini_set('memory_limit', '1G');
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', 0);

        // Validasi input
        $request->validate([
            'tipe' => 'required|in:karousel,video,mitra',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi,webm,mkv|max:2097152', // 2GB
            'youtube_url' => 'nullable|url',
            'urutan' => 'nullable|integer'
        ]);

        // Validasi: minimal salah satu harus ada (file atau YouTube URL)
        if (!$request->hasFile('file') && !$request->youtube_url) {
            return redirect()->back()
                ->withErrors(['file' => 'File atau YouTube URL harus diisi.'])
                ->withInput();
        }

        // Handle file upload
        $filePath = null;
        $fileName = null;
        $fileSize = 0;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('konten_public/' . $request->tipe, $fileName, 'public');
            $fileSize = $file->getSize();
        }

        // Extract YouTube ID jika ada
        $youtubeId = null;
        if ($request->youtube_url) {
            $youtubeId = $this->extractYouTubeId($request->youtube_url);
        }

        // Insert ke database menggunakan Eloquent
        PublicContentNew::create([
            'tipe' => $request->tipe,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'youtube_url' => $request->youtube_url,
            'youtube_id' => $youtubeId,
            'urutan' => $request->urutan ?? 0,
            'status' => 'aktif',
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', ucfirst($request->tipe) . ' berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi,webm,mkv|max:2097152',
            'youtube_url' => 'nullable|url',
            'urutan' => 'nullable|integer',
            'status' => 'required|in:aktif,non-aktif'
        ]);

        // Cari data yang akan diupdate
        $publicContent = PublicContentNew::find($id);
        if (!$publicContent) {
            return redirect()->back()->with('error', 'Konten tidak ditemukan!');
        }

        // Prepare data update
        $updateData = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'status' => $request->status
        ];

        // Handle YouTube URL
        if ($request->youtube_url) {
            $updateData['youtube_url'] = $request->youtube_url;
            $updateData['youtube_id'] = $this->extractYouTubeId($request->youtube_url);
        } else {
            $updateData['youtube_url'] = null;
            $updateData['youtube_id'] = null;
        }

        // Handle file upload baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($publicContent->file_path && Storage::exists('public/' . $publicContent->file_path)) {
                Storage::delete('public/' . $publicContent->file_path);
            }

            // Upload file baru
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($request->judul) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('konten_public/' . $publicContent->tipe, $fileName, 'public');

            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $fileName;
            $updateData['file_size'] = $file->getSize();
        }

        // Update database menggunakan Eloquent
        $publicContent->update($updateData);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage (Soft Delete)
     */
    public function destroy($id)
    {
        $publicContent = PublicContentNew::find($id);

        if (!$publicContent) {
            return redirect()->back()->with('error', 'Konten tidak ditemukan!');
        }

        // Soft delete - tidak menghapus file karena masih bisa di-restore
        $publicContent->delete();

        return redirect()->back()->with('success', 'Konten berhasil dihapus!');
    }

    /**
     * Update urutan konten via AJAX
     */
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.urutan' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            PublicContentNew::where('id', $item['id'])
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui!']);
    }

    /**
     * Extract YouTube video ID from URL
     * 
     * @param string $url
     * @return string|null
     */
    private function extractYouTubeId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $url, $matches);
        return isset($matches[1]) ? $matches[1] : null;
    }
}
