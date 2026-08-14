<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sub_title',
        'description',
        'volume_ml',
        'alcohol_percentage',
        'taste_notes',
        'price',
        'original_price',
        'currency',
        'badge',
        'is_featured',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'alcohol_percentage' => 'float',
        'volume_ml' => 'integer',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ' . $this->currency;
    }
}
