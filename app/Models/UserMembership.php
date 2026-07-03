<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMembership extends Model
{
    protected $fillable = [
        'user_id', 'plan', 'plan_name', 'price',
        'status', 'cardholder_name', 'card_last_four',
        'starts_at', 'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->ends_at->isFuture();
    }

    public function daysRemaining(): int
    {
        return max(0, (int) now()->diffInDays($this->ends_at, false));
    }

    public function progressPercent(): int
    {
        $total = $this->starts_at->diffInDays($this->ends_at);
        $used  = $this->starts_at->diffInDays(now());
        return $total > 0 ? min(100, (int) (($used / $total) * 100)) : 100;
    }
}
