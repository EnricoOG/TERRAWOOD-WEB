<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLocaleTranslations;

class Partner extends Model
{
    use HasLocaleTranslations;
    protected $fillable = [
        'translations',
        'name',
        'type',
        'slug',
        'description',
        'logo',
        'website',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'is_active' => 'boolean',
        ];
    }
}