<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupClass extends Model
{
    protected $fillable = [
        'trainer_id', 'name', 'sala', 'days_of_week',
        'time_start', 'sessions_per_week', 'monthly_price',
        'description', 'is_active',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function scheduleLabel(): string
    {
        return "{$this->sessions_per_week}x nedeljno · {$this->days_of_week} u {$this->time_start}";
    }
}
