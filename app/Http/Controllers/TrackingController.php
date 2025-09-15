<?php

namespace App\Http\Controllers;

use App\Models\PermohonanLayanan;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'nomor_permohonan' => 'required|string'
        ]);

        $nomorPermohonan = trim($request->nomor_permohonan);

        // Cari berdasarkan nomor permohonan atau ID
        $permohonan = PermohonanLayanan::where('nomor_permohonan', $nomorPermohonan)
            ->orWhere('id', $nomorPermohonan)
            ->first();

        if (!$permohonan) {
            return redirect()->route('public.tracking.index')->with('error', 'Nomor permohonan tidak ditemukan. Pastikan nomor yang Anda masukkan benar.');
        }

        return view('tracking.show', compact('permohonan'));
    }
}
