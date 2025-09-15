<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Profil::getOrCreateDefault();

        return view('admin.profil.index', compact('profil'));
    }

    // Update Profil Dinas
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'tupoksi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $profil = Profil::getOrCreateDefault();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($profil->logo && Storage::exists('public/' . $profil->logo)) {
                Storage::delete('public/' . $profil->logo);
            }

            $logoPath = $request->file('logo')->store('profil', 'public');
            $profil->logo = $logoPath;
        }

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Delete old background image
            if ($profil->background_image && Storage::exists('public/' . $profil->background_image)) {
                Storage::delete('public/' . $profil->background_image);
            }

            $backgroundPath = $request->file('background_image')->store('profil', 'public');
            $profil->background_image = $backgroundPath;
        }

        // Update other fields
        $profil->fill($request->except(['logo', 'background_image']));
        $profil->save();

        return redirect()->back()->with('success', 'Profil dinas berhasil diperbarui');
    }
}
