<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramStatusHistory;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::with('statusHistories')
            ->latest()
            ->paginate(10);
        return view('admin.program.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|max:255',
            'deskripsi' => 'required',
            'status' => 'nullable|in:Berjalan,Selesai,Perencanaan,Ditunda,Dibatalkan',
            'lokasi' => 'required|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai'
        ]);

        // Buat program baru - status akan ditentukan otomatis di model
        $data = $request->all();

        // Jika status tidak diisi, akan ditentukan otomatis oleh model
        if (empty($data['status'])) {
            unset($data['status']);
        }

        $program = Program::create($data);

        return redirect()->route('admin.konten.program.index')
            ->with('success', 'Program berhasil ditambahkan dengan status: ' . $program->status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $program->load(['statusHistories.user']);
        return view('admin.program.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('admin.program.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'nama_program' => 'required|max:255',
            'deskripsi' => 'required',
            'status' => 'required|in:Berjalan,Selesai,Perencanaan,Ditunda,Dibatalkan',
            'lokasi' => 'required|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai'
        ]);

        $statusLama = $program->status;
        $statusBaru = $request->status;

        $program->update($request->all());

        // Jika status diubah manual, catat perubahan
        if ($statusLama !== $statusBaru) {
            $program->recordStatusChange($statusLama, $statusBaru, 'manual', 'Status diubah manual oleh admin');
        }

        return redirect()->route('admin.konten.program.index')
            ->with('success', 'Program berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.konten.program.index')
            ->with('success', 'Program berhasil dihapus');
    }

    /**
     * Update status program secara manual
     */
    public function updateStatus(Request $request, Program $program)
    {
        $request->validate([
            'status' => 'required|in:Berjalan,Selesai,Perencanaan,Ditunda,Dibatalkan',
            'keterangan' => 'nullable|string|max:500'
        ]);

        $statusLama = $program->status;
        $statusBaru = $request->status;
        $keterangan = $request->keterangan;

        if ($statusLama !== $statusBaru) {
            $program->status = $statusBaru;
            $program->save();

            $program->recordStatusChange($statusLama, $statusBaru, 'manual', $keterangan);

            return response()->json([
                'success' => true,
                'message' => "Status program berhasil diubah dari {$statusLama} ke {$statusBaru}",
                'new_status' => $statusBaru,
                'badge_class' => $program->status_badge
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Status program tidak berubah'
        ]);
    }

    /**
     * Sync status semua program berdasarkan tanggal
     */
    public function syncStatuses()
    {
        $programs = Program::whereNotIn('status', ['Selesai', 'Dibatalkan'])->get();
        $updatedCount = 0;

        foreach ($programs as $program) {
            if ($program->updateStatusByDate('manual', 'Sinkronisasi status manual oleh admin')) {
                $updatedCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil memperbarui status {$updatedCount} program berdasarkan tanggal.");
    }

    /**
     * Get status history for a program
     */
    public function getStatusHistory(Program $program)
    {
        $histories = $program->statusHistories()
            ->with('user')
            ->orderBy('tanggal_perubahan', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'histories' => $histories->map(function ($history) {
                return [
                    'id' => $history->id,
                    'status_lama' => $history->status_lama,
                    'status_baru' => $history->status_baru,
                    'trigger_type' => $history->trigger_type,
                    'trigger_description' => $history->getTriggerDescription(),
                    'keterangan' => $history->keterangan,
                    'tanggal_perubahan' => $history->tanggal_perubahan->format('d M Y H:i'),
                    'user_name' => $history->user ? $history->user->name : 'Sistem'
                ];
            })
        ]);
    }
}
