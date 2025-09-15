<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'status_code',
        'old_values',
        'new_values'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    // Methods
    public static function log($action, $model = null, $description = null, $oldValues = null, $newValues = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $request = request();

        return static::create([
            'user_id' => $user ? $user->id : null,
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'old_values' => $oldValues,
            'new_values' => $newValues
        ]);
    }

    public function getActionLabelAttribute()
    {
        $labels = [
            'login' => 'Login',
            'logout' => 'Logout',
            'create' => 'Membuat',
            'update' => 'Mengubah',
            'delete' => 'Menghapus',
            'view' => 'Melihat',
            'upload' => 'Upload',
            'download' => 'Download'
        ];

        return $labels[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get color for action badge
     */
    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'view' => 'info',
            'download' => 'primary',
            default => 'secondary'
        };
    }
}
