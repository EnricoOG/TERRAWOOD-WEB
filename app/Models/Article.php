<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLocaleTranslations;

class Article extends Model
{
    use HasLocaleTranslations;
    protected $fillable = [
        'translations',
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'is_published',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}