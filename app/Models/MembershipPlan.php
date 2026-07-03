<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = [
        'slug', 'name', 'price', 'features', 'features_off',
        'is_featured', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'features'     => 'array',
        'features_off' => 'array',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function toCheckoutArray(): array
    {
        return [
            'slug'         => $this->slug,
            'name'         => $this->name,
            'price'        => $this->price,
            'features'     => $this->features ?? [],
            'features_off' => $this->features_off ?? [],
            'featured'     => $this->is_featured,
        ];
    }

    public static function active()
    {
        return static::where('is_active', true)->orderBy('sort_order');
    }
}
