<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trainer extends Model
{
    protected $fillable = [
        'name', 'specialty', 'bio', 'session_price',
        'avatar_initials', 'avatar_gradient', 'photo', 'is_active', 'trainer_type',
    ];

    public function sessions(): HasMany
    {
        return $this->hasMany(TrainingSession::class);
    }

    public function groupClasses(): HasMany
    {
        return $this->hasMany(GroupClass::class);
    }

    public function isPersonal(): bool
    {
        return $this->trainer_type === 'personal';
    }

    public function isGroup(): bool
    {
        return $this->trainer_type === 'group';
    }

    public function photoUrl(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function isBookedAt(string $datetime): bool
    {
        return $this->sessions()
            ->where('scheduled_at', $datetime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }
}
