<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStatusHistory extends Model
{
    protected $fillable = [
        'program_id',
        'status_lama',
        'status_baru',
        'trigger_type',
        'keterangan',
        'tanggal_perubahan',
        'user_id'
    ];

    protected $casts = [
        'tanggal_perubahan' => 'datetime'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'Perencanaan' => 'bg-warning text-dark',
            'Berjalan' => 'bg-primary',
            'Selesai' => 'bg-success',
            'Ditunda' => 'bg-secondary',
            'Dibatalkan' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get trigger type description
     */
    public function getTriggerDescription()
    {
        return match($this->trigger_type) {
            'manual' => 'Diubah manual oleh ' . ($this->user ? $this->user->name : 'Admin'),
            'auto_date' => 'Otomatis berdasarkan tanggal',
            'auto_scheduler' => 'Otomatis oleh sistem scheduler',
            default => 'Perubahan sistem'
        };
    }
}
