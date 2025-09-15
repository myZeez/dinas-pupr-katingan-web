<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('admin.video.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->only(['title', 'description', 'video_url', 'status']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        Video::create($data);

        return redirect()->route('admin.konten.video.index')->with('success', 'Video berhasil ditambahkan');
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.show', compact('video'));
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_url' => 'required|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|in:active,inactive'
        ]);

        $data = $request->only(['title', 'description', 'video_url', 'status']);
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        $video->update($data);

        return redirect()->route('admin.konten.video.index')->with('success', 'Video berhasil diperbarui');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        // Delete thumbnail
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.konten.video.index')->with('success', 'Video berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $video = Video::findOrFail($id);
        $video->status = $video->status === 'active' ? 'inactive' : 'active';
        $video->save();

        return redirect()->back()->with('success', 'Status video berhasil diubah');
    }
}
