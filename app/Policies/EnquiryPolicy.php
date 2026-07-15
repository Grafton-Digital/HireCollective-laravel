<?php

namespace App\Policies;

use App\Models\Enquiry;
use App\Models\User;

class EnquiryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isBoutiqueOwner();
    }

    public function view(User $user, Enquiry $enquiry): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $enquiry->boutique_id;
    }

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $user, Enquiry $enquiry): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->boutique_id === $enquiry->boutique_id;
    }

    public function delete(User $user, Enquiry $enquiry): bool
    {
        return $user->isAdmin();
    }
}
