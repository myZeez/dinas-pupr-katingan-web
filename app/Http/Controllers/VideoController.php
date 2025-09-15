<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('status', 'active')->latest()->paginate(12);
        return view('public.videos.index', compact('videos'));
    }

    public function show($id)
    {
        $video = Video::where('status', 'active')->findOrFail($id);
        $relatedVideos = Video::where('status', 'active')
            ->where('id', '!=', $id)
            ->latest()
            ->limit(6)
            ->get();

        return view('public.videos.show', compact('video', 'relatedVideos'));
    }
}
