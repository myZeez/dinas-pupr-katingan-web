<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     * Redirect to integrated content page
     */
    public function index()
    {
        return redirect()->route('admin.konten.index', ['tab' => 'berita']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Berita store method called', ['request_data' => $request->all()]);

        try {
            $request->validate([
                'judul' => 'required|max:255',
                'konten' => 'required',
                'tanggal_publikasi' => 'nullable|date',
                'penulis' => 'nullable|string|max:255',
                'status_publikasi' => 'required|in:draft,published,archived',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB
            ]);

            Log::info('Validation passed');

            $data = [
                'judul' => $request->judul,
                'konten' => $request->konten,
                'tanggal' => $request->tanggal_publikasi ?? now(),
                'author' => $request->penulis ?? Auth::user()->name ?? 'Admin',
                'status' => $request->status_publikasi,
            ];

            // Set tanggal_publikasi jika status published
            if ($data['status'] === 'published') {
                $data['tanggal_publikasi'] = $data['tanggal'];
            }

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['thumbnail'] = $file->storeAs('berita', $filename, 'public');
                Log::info('Image uploaded', ['filename' => $data['thumbnail']]);
            }

            $berita = Berita::create($data);
            Log::info('Berita created', ['berita_id' => $berita->id]);

            return redirect()->route('admin.konten.index', ['tab' => 'berita'])
                ->with('success', 'Berita berhasil ditambahkan!')
                ->with('alert_type', 'success')
                ->with('alert_icon', 'bi-check-circle');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Terjadi kesalahan validasi!')
                ->with('alert_type', 'danger')
                ->with('alert_icon', 'bi-exclamation-triangle');
        } catch (\Exception $e) {
            Log::error('General error in store', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->with('alert_type', 'danger')
                ->with('alert_icon', 'bi-x-circle');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'konten' => 'required',
            'tanggal' => 'required|date',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['judul', 'konten', 'tanggal', 'author', 'status']);

        // Set tanggal_publikasi jika status published dan belum pernah dipublish
        if ($data['status'] === 'published' && $berita->status !== 'published') {
            $data['tanggal_publikasi'] = now();
        } elseif ($data['status'] === 'published' && $berita->tanggal_publikasi) {
            // Keep existing publication date if already published
            $data['tanggal_publikasi'] = $berita->tanggal_publikasi;
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.konten.index', ['tab' => 'berita'])
            ->with('success', 'Berita berhasil diperbarui')
            ->with('alert_type', 'success')
            ->with('alert_icon', 'bi-check-circle');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        // Delete thumbnail if exists
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        $berita->delete();

        return redirect()->route('admin.konten.index', ['tab' => 'berita'])
            ->with('success', 'Berita berhasil dihapus')
            ->with('alert_type', 'success')
            ->with('alert_icon', 'bi-trash');
    }

    /**
     * Toggle status publikasi berita
     */
    public function toggleStatus(Berita $berita)
    {
        $newStatus = $berita->status === 'published' ? 'draft' : 'published';

        // Set tanggal publikasi jika baru pertama kali dipublish
        if ($newStatus === 'published' && !$berita->tanggal_publikasi) {
            $berita->tanggal_publikasi = now();
        }

        $berita->update(['status' => $newStatus]);

        return back()->with('success', 'Status berita berhasil diubah')
            ->with('alert_type', 'info')
            ->with('alert_icon', 'bi-arrow-repeat');
    }
}
