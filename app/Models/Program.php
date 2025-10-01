<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Program extends Model
{
    use SoftDeletes;

    protected $table = 'program';

    protected $fillable = [
        'nama_program',
        'deskripsi',
        'status',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime'
    ];

    /**
     * Relasi ke riwayat perubahan status
     */
    public function statusHistories()
    {
        return $this->hasMany(ProgramStatusHistory::class)->orderBy('tanggal_perubahan', 'desc');
    }

    /**
     * Tentukan status berdasarkan tanggal
     */
    public function determineStatusByDate(): string
    {
        $now = Carbon::now();

        // Jika belum ada tanggal mulai atau selesai
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 'Perencanaan';
        }

        // Jika sudah melewati tanggal selesai
        if ($now->greaterThan($this->tanggal_selesai)) {
            return 'Selesai';
        }

        // Jika sudah melewati atau sama dengan tanggal mulai
        if ($now->greaterThanOrEqualTo($this->tanggal_mulai)) {
            return 'Berjalan';
        }

        // Jika masih sebelum tanggal mulai
        return 'Perencanaan';
    }

    /**
     * Update status secara otomatis berdasarkan tanggal
     */
    public function updateStatusByDate($triggerType = 'auto_date', $keterangan = null): bool
    {
        $statusBaru = $this->determineStatusByDate();
        $statusLama = $this->status;

        // Jika status tidak berubah, return false
        if ($statusLama === $statusBaru) {
            return false;
        }

        // Update status program
        $this->status = $statusBaru;
        $this->save();

        // Catat perubahan status
        $this->recordStatusChange($statusLama, $statusBaru, $triggerType, $keterangan);

        return true;
    }

    /**
     * Catat perubahan status ke history
     */
    public function recordStatusChange($statusLama, $statusBaru, $triggerType = 'manual', $keterangan = null)
    {
        ProgramStatusHistory::create([
            'program_id' => $this->id,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'trigger_type' => $triggerType,
            'keterangan' => $keterangan ?? $this->generateStatusChangeDescription($statusLama, $statusBaru),
            'tanggal_perubahan' => now(),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Generate deskripsi perubahan status
     */
    private function generateStatusChangeDescription($statusLama, $statusBaru): string
    {
        $descriptions = [
            'Perencanaan' => [
                'Berjalan' => 'Program dimulai sesuai jadwal',
                'Selesai' => 'Program diselesaikan',
                'Ditunda' => 'Program ditunda',
                'Dibatalkan' => 'Program dibatalkan'
            ],
            'Berjalan' => [
                'Selesai' => 'Program selesai tepat waktu',
                'Ditunda' => 'Program dihentikan sementara',
                'Dibatalkan' => 'Program dibatalkan selama pelaksanaan'
            ],
            'Ditunda' => [
                'Berjalan' => 'Program dilanjutkan kembali',
                'Selesai' => 'Program diselesaikan',
                'Dibatalkan' => 'Program dibatalkan'
            ]
        ];

        return $descriptions[$statusLama][$statusBaru] ?? "Status berubah dari {$statusLama} ke {$statusBaru}";
    }

    /**
     * Get status badge untuk UI
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Perencanaan' => 'bg-warning text-dark',
            'Berjalan' => 'bg-primary',
            'Selesai' => 'bg-success',
            'Ditunda' => 'bg-secondary',
            'Dibatalkan' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Check apakah program overdue
     */
    public function isOverdue(): bool
    {
        return $this->tanggal_selesai &&
               Carbon::now()->greaterThan($this->tanggal_selesai) &&
               $this->status !== 'Selesai';
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentage(): int
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) {
            return 0;
        }

        $now = Carbon::now();
        $start = $this->tanggal_mulai;
        $end = $this->tanggal_selesai;

        if ($now->lessThan($start)) {
            return 0;
        }

        if ($now->greaterThan($end)) {
            return 100;
        }

        $totalDays = $start->diffInDays($end);
        $passedDays = $start->diffInDays($now);

        return $totalDays > 0 ? round(($passedDays / $totalDays) * 100) : 0;
    }

    /**
     * Update status saat model berubah
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            // Set status awal berdasarkan tanggal saat membuat program baru
            if (!$program->status) {
                $program->status = $program->determineStatusByDate();
            }
        });

        static::created(function ($program) {
            // Catat status awal
            $program->recordStatusChange(null, $program->status, 'manual', 'Program dibuat dengan status awal');
        });

        static::updating(function ($program) {
            // Jika tanggal berubah, update status otomatis
            if ($program->isDirty(['tanggal_mulai', 'tanggal_selesai'])) {
                $statusBaru = $program->determineStatusByDate();
                if ($program->status !== $statusBaru) {
                    $statusLama = $program->getOriginal('status');
                    $program->status = $statusBaru;

                    // Catat perubahan setelah model disimpan
                    static::updated(function ($updatedProgram) use ($statusLama, $statusBaru) {
                        $updatedProgram->recordStatusChange($statusLama, $statusBaru, 'auto_date', 'Status diperbarui otomatis karena perubahan tanggal');
                    });
                }
            }
        });
    }
}
