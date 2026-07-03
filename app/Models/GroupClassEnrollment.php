<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupClassEnrollment extends Model
{
    protected $fillable = ['user_id', 'group_class_id', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groupClass(): BelongsTo
    {
        return $this->belongsTo(GroupClass::class);
    }
}
