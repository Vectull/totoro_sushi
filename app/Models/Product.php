<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'composition',
        'price',
        'old_price',
        'discount_percent',
        'weight',
        'pieces',
        'is_active',
        'is_popular',
        'is_new',
        'is_promotion',
        'labels',
        'characteristics',
        'allergens',
    ];

    protected $casts = [
        'labels' => 'array',
        'characteristics' => 'array',
        'allergens' => 'array',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productAttributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function productModifiers(): HasMany
    {
        return $this->hasMany(ProductModifier::class);
    }
}
