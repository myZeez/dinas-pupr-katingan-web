<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profil;

class ProfilDinasController extends Controller
{
    public function index()
    {
        $profils = Profil::all();
        return view('admin.profil-dinas.index', compact('profils'));
    }

    public function create()
    {
        return view('admin.profil-dinas.create');
    }

    public function store(Request $request)
    {
        // Implementation for storing profil dinas
        return redirect()->route('admin.profil-dinas.index')->with('success', 'Profil dinas berhasil dibuat');
    }

    public function show($id)
    {
        $profil = Profil::findOrFail($id);
        return view('admin.profil-dinas.show', compact('profil'));
    }

    public function edit($id)
    {
        $profil = Profil::findOrFail($id);
        return view('admin.profil-dinas.edit', compact('profil'));
    }

    public function update(Request $request, $id)
    {
        // Implementation for updating profil dinas
        return redirect()->route('admin.profil-dinas.index')->with('success', 'Profil dinas berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Implementation for deleting profil dinas
        return redirect()->route('admin.profil-dinas.index')->with('success', 'Profil dinas berhasil dihapus');
    }
}
