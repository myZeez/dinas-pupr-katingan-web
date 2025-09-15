<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileDownload;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class FileDownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     * Redirect to integrated content page
     */
    public function index()
    {
        return redirect()->route('admin.konten.index', ['tab' => 'download']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.konten.file-download.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|max:100000', // 100MB
            'kategori' => 'required|in:dokumen,formulir,peraturan,panduan,infrastruktur,perencanaan,pembangunan,pemeliharaan,monitoring,lainnya',
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
            $filePath = $file->storeAs('downloads', $fileName, 'public');

            $fileDownload = FileDownload::create([
                'nama_file' => $request->nama_file,
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_type' => $file->getClientMimeType(),
                'kategori' => $request->kategori ?: 'dokumen',
                'urutan' => $request->urutan ?? 0,
                'status' => $request->status,
                'user_id' => Auth::id()
            ]);

            // Log activity
            ActivityLog::log('create', $fileDownload, 'Menambah file download: ' . $fileDownload->nama_file);

            return redirect()->route('admin.konten.index', ['tab' => 'download'])
                ->with('success', 'File download berhasil ditambahkan!');
        }

        return redirect()->back()
            ->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(FileDownload $fileDownload)
    {
        return view('admin.konten.file-download.show', compact('fileDownload'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileDownload $fileDownload)
    {
        return view('admin.konten.file-download.edit', compact('fileDownload'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FileDownload $fileDownload)
    {
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'nullable|file|max:100000', // 100MB
            'kategori' => 'required|in:dokumen,formulir,peraturan,panduan,infrastruktur,perencanaan,pembangunan,pemeliharaan,monitoring,lainnya',
            'urutan' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,non-aktif'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldValues = $fileDownload->toArray();

        $fileDownload->nama_file = $request->nama_file;
        $fileDownload->deskripsi = $request->deskripsi;
        $fileDownload->kategori = $request->kategori ?: 'dokumen';
        $fileDownload->urutan = $request->urutan ?? 0;
        $fileDownload->status = $request->status;

        // Handle file update
        if ($request->hasFile('file')) {
            // Delete old file
            if ($fileDownload->file_path && Storage::disk('public')->exists($fileDownload->file_path)) {
                Storage::disk('public')->delete($fileDownload->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('downloads', $fileName, 'public');

            $fileDownload->file_path = $filePath;
            $fileDownload->file_name = $file->getClientOriginalName();
            $fileDownload->file_size = $file->getSize();
            $fileDownload->file_type = $file->getClientMimeType();
        }

        $fileDownload->save();

        // Log activity
        ActivityLog::log('update', $fileDownload, 'Mengubah file download: ' . $fileDownload->nama_file, $oldValues, $fileDownload->toArray());

        return redirect()->route('admin.konten.index', ['tab' => 'download']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FileDownload $fileDownload)
    {
        $judulFile = $fileDownload->judul;

        // Delete file
        if ($fileDownload->file_path && Storage::disk('public')->exists($fileDownload->file_path)) {
            Storage::disk('public')->delete($fileDownload->file_path);
        }

        $fileDownload->delete();

        // Log activity
        ActivityLog::log('delete', null, 'Menghapus file download: ' . $judulFile);

        return redirect()->route('admin.konten.index', ['tab' => 'download']);
    }

    /**
     * Download file
     */
    public function download(FileDownload $fileDownload)
    {
        if (!$fileDownload->file_path || !Storage::disk('public')->exists($fileDownload->file_path)) {
            return redirect()->back();
        }

        // Increment download count
        $fileDownload->increment('download_count');

        // Log activity
        ActivityLog::log('download', $fileDownload, 'Download file: ' . $fileDownload->judul);

        return Response::download(storage_path('app/public/' . $fileDownload->file_path), $fileDownload->file_name);
    }
}
