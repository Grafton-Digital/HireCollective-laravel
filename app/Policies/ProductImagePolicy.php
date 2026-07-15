<?php

namespace App\Policies;

use App\Models\ProductImage;
use App\Models\User;

class ProductImagePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ProductImage $image): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $image->product->boutique_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isBoutiqueOwner();
    }

    public function update(User $user, ProductImage $image): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $image->product->boutique_id;
    }

    public function delete(User $user, ProductImage $image): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $image->product->boutique_id;
    }
}
