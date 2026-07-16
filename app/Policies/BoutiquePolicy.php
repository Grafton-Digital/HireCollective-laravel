<?php

namespace App\Policies;

use App\Models\Boutique;
use App\Models\User;

class BoutiquePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Boutique $boutique): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isBoutiqueOwner() && $user->boutique_id === $boutique->id;
    }

    public function create(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isBoutiqueOwner() && $user->boutique_id === null) {
            return ! Boutique::where('submitted_by', $user->id)
                ->whereIn('status', [Boutique::STATUS_PENDING, Boutique::STATUS_APPROVED])
                ->exists();
        }

        return false;
    }

    public function update(User $user, Boutique $boutique): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->isBoutiqueOwner() && $user->boutique_id === $boutique->id;
    }

    public function delete(User $user, Boutique $boutique): bool
    {
        return $user->isAdmin();
    }
}
