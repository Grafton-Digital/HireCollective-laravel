<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    'status',
    'submitted_by',
    'pending_email',
    'pending_password',
])]
class Boutique extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_REJECTED = 'rejected';

    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'social_links' => 'array',
            'is_active' => 'boolean',
            'pending_password' => 'hashed',
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

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function approve(): void
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'is_active' => true,
        ]);

        if ($this->pending_email && $this->pending_password) {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->pending_email,
                'password' => $this->pending_password,
                'role' => 'boutique_owner',
                'boutique_id' => $this->id,
            ]);

            $this->update([
                'submitted_by' => $user->id,
                'pending_email' => null,
                'pending_password' => null,
            ]);
        }
    }

    public function reject(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }
}
