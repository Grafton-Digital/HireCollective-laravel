<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'boutique_id',
    'name',
    'designer',
    'slug',
    'description',
    'price',
    'is_variable',
    'is_available',
    'featured_image',
    'is_active',
])]
class Product extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_variable' => 'boolean',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function colours(): BelongsToMany
    {
        return $this->belongsToMany(Colour::class);
    }

    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }
}
