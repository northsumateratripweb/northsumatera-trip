<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'name',
        'location',
        'category',
        'phone',
        'address',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Ambil list nama hotel aktif untuk dropdown.
     */
    public static function activeOptions(): array
    {
        return static::where('is_active', true)
            ->orderBy('location')
            ->orderBy('name')
            ->pluck('name', 'name')
            ->toArray();
    }
}
