<?php

namespace App\Policies;

use App\Models\ProductVariant;
use App\Models\User;

class ProductVariantPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProductVariant $variant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $variant->product->boutique_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isBoutiqueOwner();
    }

    public function update(User $user, ProductVariant $variant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $variant->product->boutique_id;
    }

    public function delete(User $user, ProductVariant $variant): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $variant->product->boutique_id;
    }
}
