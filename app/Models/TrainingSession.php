<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSession extends Model
{
    protected $fillable = [
        'trainer_id', 'user_id', 'scheduled_at', 'status', 'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'confirmed'  => 'Potvrdjeno',
            'cancelled'  => 'Otkazano',
            default      => 'Na cekanju',
        };
    }

    public function statusClass(): string
    {
        return match($this->status) {
            'confirmed'  => 'badge--confirmed',
            'cancelled'  => 'badge--cancelled',
            default      => 'badge--pending',
        };
    }
}
