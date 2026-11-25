<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLocaleTranslations;

class Portfolio extends Model
{
    use HasLocaleTranslations;
    protected $fillable = [
        'translations',
        'title',
        'slug',
        'client_name',
        'category',
        'description',
        'image',
        'project_date',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'project_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }
}
