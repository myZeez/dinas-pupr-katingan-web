<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StrukturController extends Controller
{
    public function index(Request $request)
    {
        $query = Struktur::query();

        // Filter berdasarkan jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        // Filter berdasarkan unit kerja
        if ($request->filled('unit_kerja')) {
            $query->where('unit_kerja', $request->unit_kerja);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $strukturs = $query->orderBy('urutan')->paginate(15);

        // Ambil data untuk dropdown filter
        $jabatanList = Struktur::select('jabatan')
            ->distinct()
            ->whereNotNull('jabatan')
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $unitKerjaList = Struktur::select('unit_kerja')
            ->distinct()
            ->whereNotNull('unit_kerja')
            ->orderBy('unit_kerja')
            ->pluck('unit_kerja');

        return view('admin.struktur.index', compact('strukturs', 'jabatanList', 'unitKerjaList'));
    }

    public function peta()
    {
        return view('admin.struktur.peta');
    }

    public function trashed()
    {
        $strukturs = Struktur::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.struktur.trashed', compact('strukturs'));
    }

    public function create()
    {
        return view('admin.struktur.create');
    }

    public function store(Request $request)
    {
        $jabatanOptions = implode(',', \App\Models\Struktur::getJabatanOptions());
        $golonganOptions = implode(',', \App\Models\Struktur::getGolonganOptions());
        $unitKerjaOptions = implode(',', \App\Models\Struktur::getUnitKerjaOptions());

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:' . $jabatanOptions,
            'nip' => 'nullable|string|max:20|unique:struktur,nip',
            'golongan' => 'nullable|in:' . $golonganOptions,
            'unit_kerja' => 'nullable|in:' . $unitKerjaOptions,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|in:aktif,tidak_aktif',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'jabatan.in' => 'Jabatan tidak valid',
            'nip.unique' => 'NIP sudah terdaftar',
            'golongan.in' => 'Golongan tidak valid',
            'unit_kerja.in' => 'Unit kerja tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan minimal 0',
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status tidak valid',
        ]);

        try {
            $data = $request->only(['nama', 'jabatan', 'nip', 'golongan', 'unit_kerja', 'email', 'telepon', 'alamat', 'urutan', 'status', 'keterangan']);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = 'struktur_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('foto/struktur', $fileName, 'public');
                $data['foto'] = $filePath;
            }

            Struktur::create($data);

            return redirect()->route('admin.struktur.index')
                ->with('success', 'Data struktur berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating struktur: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan data struktur.');
        }
    }

    public function edit(Struktur $struktur)
    {
        return view('admin.struktur.edit', compact('struktur'));
    }

    public function update(Request $request, Struktur $struktur)
    {
        $jabatanOptions = implode(',', \App\Models\Struktur::getJabatanOptions());
        $golonganOptions = implode(',', \App\Models\Struktur::getGolonganOptions());
        $unitKerjaOptions = implode(',', \App\Models\Struktur::getUnitKerjaOptions());

        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:' . $jabatanOptions,
            'nip' => 'nullable|string|max:20|unique:struktur,nip,' . $struktur->id,
            'golongan' => 'nullable|in:' . $golonganOptions,
            'unit_kerja' => 'nullable|in:' . $unitKerjaOptions,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
            'urutan' => 'required|integer|min:0',
            'status' => 'required|in:aktif,tidak_aktif',
            'memerlukan_plt' => 'nullable|boolean',
            'plt_struktur_id' => 'nullable|exists:struktur,id',
            'plt_nama_manual' => 'nullable|string|max:255',
            'plt_jabatan_manual' => 'nullable|string|max:255',
            'plt_asal_instansi' => 'nullable|string|max:255',
            'plt_mulai' => 'nullable|date',
            'plt_selesai' => 'nullable|date|after_or_equal:plt_mulai',
            'plt_status' => 'nullable|in:aktif,tidak_aktif,selesai',
            'plt_keterangan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'jabatan.in' => 'Jabatan tidak valid',
            'nip.unique' => 'NIP sudah terdaftar',
            'golongan.in' => 'Golongan tidak valid',
            'unit_kerja.in' => 'Unit kerja tidak valid',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan minimal 0',
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status tidak valid',
            'plt_struktur_id.exists' => 'PLT internal yang dipilih tidak valid',
            'plt_selesai.after_or_equal' => 'Tanggal selesai PLT harus setelah atau sama dengan tanggal mulai',
        ]);

        try {
            $data = $request->only([
                'nama',
                'jabatan',
                'nip',
                'golongan',
                'unit_kerja',
                'urutan',
                'status',
                'memerlukan_plt',
                'plt_struktur_id',
                'plt_nama_manual',
                'plt_jabatan_manual',
                'plt_asal_instansi',
                'plt_mulai',
                'plt_selesai',
                'plt_status',
                'plt_keterangan'
            ]);

            // Handle PLT logic
            if (!isset($data['memerlukan_plt'])) {
                $data['memerlukan_plt'] = false;
                // Clear PLT fields if not needed
                $data['plt_struktur_id'] = null;
                $data['plt_nama_manual'] = null;
                $data['plt_jabatan_manual'] = null;
                $data['plt_asal_instansi'] = null;
                $data['plt_mulai'] = null;
                $data['plt_selesai'] = null;
                $data['plt_status'] = null;
                $data['plt_keterangan'] = null;
            } else {
                // If PLT internal is selected, clear manual fields
                if ($data['plt_struktur_id']) {
                    $data['plt_nama_manual'] = null;
                    $data['plt_jabatan_manual'] = null;
                    $data['plt_asal_instansi'] = null;
                }
                // If PLT manual is used, clear internal selection
                if ($data['plt_nama_manual']) {
                    $data['plt_struktur_id'] = null;
                }
            }

            if ($request->hasFile('foto')) {
                if ($struktur->foto) {
                    Storage::disk('public')->delete($struktur->foto);
                }
                $file = $request->file('foto');
                $fileName = 'struktur_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('foto/struktur', $fileName, 'public');
                $data['foto'] = $filePath;
            }

            $struktur->update($data);

            return redirect()->route('admin.struktur.index')
                ->with('success', 'Data struktur berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating struktur: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data struktur.');
        }
    }

    public function destroy(Struktur $struktur)
    {
        try {
            // Soft delete tanpa menghapus file foto
            $struktur->delete();

            return redirect()->route('admin.struktur.index')
                ->with('success', 'Data struktur berhasil dihapus (dipindah ke sampah).');
        } catch (\Exception $e) {
            Log::error('Error deleting struktur: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data struktur.');
        }
    }

    public function restore($id)
    {
        try {
            $struktur = Struktur::onlyTrashed()->findOrFail($id);
            $struktur->restore();

            return redirect()->route('admin.struktur.trashed')
                ->with('success', 'Data struktur berhasil dipulihkan.');
        } catch (\Exception $e) {
            Log::error('Error restoring struktur: ' . $e->getMessage());
            return back()->with('error', 'Gagal memulihkan data struktur.');
        }
    }

    public function forceDelete($id)
    {
        try {
            $struktur = Struktur::onlyTrashed()->findOrFail($id);

            // Hapus file foto saat force delete
            if ($struktur->foto) {
                Storage::disk('public')->delete($struktur->foto);
            }

            $struktur->forceDelete();

            return redirect()->route('admin.struktur.trashed')
                ->with('success', 'Data struktur berhasil dihapus permanen.');
        } catch (\Exception $e) {
            Log::error('Error force deleting struktur: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus permanen data struktur.');
        }
    }

    public function getJabatanByCategory($category)
    {
        try {
            Log::info('Getting jabatan for category: ' . $category);
            $jabatanList = Struktur::getJabatanByCategory($category);
            Log::info('Jabatan list count: ' . count($jabatanList));

            $response = [
                'success' => true,
                'data' => $jabatanList,
                'category' => $category,
                'count' => count($jabatanList)
            ];

            Log::info('Returning response: ' . json_encode($response));

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error in getJabatanByCategory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving jabatan data: ' . $e->getMessage(),
                'category' => $category
            ], 500);
        }
    }
}
