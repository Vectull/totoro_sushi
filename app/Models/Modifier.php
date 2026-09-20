<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modifier extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function productModifiers(): HasMany
    {
        return $this->hasMany(ProductModifier::class);
    }
}
