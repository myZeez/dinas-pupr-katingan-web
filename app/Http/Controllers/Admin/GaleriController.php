<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     * Redirect to integrated content page
     */
    public function index()
    {
        return redirect()->route('admin.konten.index', ['tab' => 'galeri']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.konten.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:foto',
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB, only images
            'kategori' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,non-aktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('galeri', $fileName, 'public');

            $galeri = Galeri::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tipe' => $request->tipe,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'kategori' => $request->kategori,
                'urutan' => $request->urutan ?? 0,
                'status' => $request->status,
                'user_id' => Auth::id()
            ]);

            // Log activity
            ActivityLog::log('create', $galeri, 'Menambah item galeri: ' . $galeri->judul);

            return redirect()->route('admin.konten.index', ['tab' => 'galeri'])
                ->with('success', 'Item galeri berhasil ditambahkan.');
        }

        return redirect()->back()
            ->with('error', 'Gagal mengupload file.')
            ->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('admin.konten.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        // Debug log
        logger('GaleriController edit called for galeri ID: ' . $galeri->id);

        return view('admin.konten.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:foto',
            'file' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:10240', // 10MB, only images
            'kategori' => 'nullable|string|max:100',
            'urutan' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,non-aktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $galeri->toArray();

        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;
        $galeri->tipe = $request->tipe;
        $galeri->kategori = $request->kategori;
        $galeri->urutan = $request->urutan ?? 0;
        $galeri->status = $request->status;

        // Handle file update
        if ($request->hasFile('file')) {
            // Delete old file
            if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
                Storage::disk('public')->delete($galeri->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('galeri', $fileName, 'public');

            $galeri->file_path = $filePath;
            $galeri->file_name = $file->getClientOriginalName();
            $galeri->file_size = $file->getSize();
        }

        $galeri->save();

        // Log activity
        ActivityLog::log('update', $galeri, 'Mengubah item galeri: ' . $galeri->judul, $oldValues, $galeri->toArray());

        return redirect()->route('admin.konten.index', ['tab' => 'galeri'])
            ->with('success', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        $judulGaleri = $galeri->judul;

        // Delete file
        if ($galeri->file_path && Storage::disk('public')->exists($galeri->file_path)) {
            Storage::disk('public')->delete($galeri->file_path);
        }

        $galeri->delete();

        // Log activity
        ActivityLog::log('delete', null, 'Menghapus item galeri: ' . $judulGaleri);

        return redirect()->route('admin.konten.index', ['tab' => 'galeri'])
            ->with('success', 'Item galeri berhasil dihapus.');
    }
}
