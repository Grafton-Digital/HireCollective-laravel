<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'description',
    'logo',
    'cover_image',
    'address',
    'city',
    'county',
    'contact_email',
    'phone',
    'opening_hours',
    'social_links',
    'is_active',
])]
class Boutique extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'social_links' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }
}
