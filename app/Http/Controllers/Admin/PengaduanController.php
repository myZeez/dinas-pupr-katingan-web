<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::latest();

        // Filter by status if provided
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('subjek', 'like', '%' . $request->search . '%');
            });
        }

        $pengaduans = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => Pengaduan::count(),
            'baru' => Pengaduan::where('status', 'Baru')->count(),
            'diproses' => Pengaduan::where('status', 'Diproses')->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduans', 'stats'));
    }

    public function show(Pengaduan $pengaduan)
    {
        // Load histories with eager loading
        $pengaduan->load(['histories' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai,Ditolak'
        ]);

        $statusLama = $pengaduan->status;
        $statusBaru = $request->status;

        // Jika status tidak berubah, tidak perlu update
        if ($statusLama === $statusBaru) {
            return back()->with('info', 'Status pengaduan sudah sama');
        }

        // Update status pengaduan
        $pengaduan->update([
            'status' => $statusBaru
        ]);

        // Simpan ke history
        PengaduanHistory::create([
            'pengaduan_id' => $pengaduan->id,
            'status_from' => $statusLama,
            'status_to' => $statusBaru,
            'action' => $statusBaru,
            'keterangan' => $this->getStatusKeterangan($statusLama, $statusBaru),
            'admin_name' => Auth::user()->name ?? 'Admin',
            'admin_email' => Auth::user()->email ?? 'admin@pupr.com'
        ]);

        $message = "Status pengaduan berhasil diubah dari '{$statusLama}' ke '{$statusBaru}'";

        return back()->with('success', $message);
    }

    private function getStatusKeterangan($statusLama, $statusBaru)
    {
        return match ($statusBaru) {
            'Baru' => 'Status dikembalikan ke status baru',
            'Diproses' => 'Pengaduan mulai diproses oleh tim',
            'Selesai' => 'Pengaduan telah diselesaikan dengan baik',
            'Ditolak' => 'Pengaduan ditolak dengan pertimbangan tertentu',
            default => "Status diubah dari {$statusLama} ke {$statusBaru}"
        };
    }

    public function destroy(Pengaduan $pengaduan)
    {
        try {
            $pengaduanId = $pengaduan->id;
            $pengaduanNama = $pengaduan->nama;
            $pengaduan->delete();

            Log::info('Pengaduan deleted successfully', ['id' => $pengaduanId]);

            return redirect()->route('admin.pengaduan.index');
        } catch (\Exception $e) {
            Log::error('Error deleting pengaduan', ['error' => $e->getMessage()]);

            return redirect()->route('admin.pengaduan.index');
        }
    }
}
