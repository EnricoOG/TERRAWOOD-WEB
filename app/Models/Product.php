<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasLocaleTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasLocaleTranslations;
    protected $fillable = [
        'translations',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'image',
        'is_featured',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    protected function casts(): array
    {
        return ['translations' => 'array'];
    }
}
