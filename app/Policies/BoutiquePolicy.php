<?php

namespace App\Policies;

use App\Models\Boutique;
use App\Models\User;

class BoutiquePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Boutique $boutique): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $boutique->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Boutique $boutique): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Boutique $boutique): bool
    {
        return $user->isAdmin();
    }
}
