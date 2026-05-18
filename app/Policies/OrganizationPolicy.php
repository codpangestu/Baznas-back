<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function update(User $user, Organization $organization): bool
    {
        // Admin can update all organizations
        if ($user->role === 'admin') {
            return true;
        }

        // Daerah users can only update their own organization
        return $user->role === 'daerah' && $user->organization_id === $organization->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Organization $organization
     * @return bool
     */
    public function delete(User $user, Organization $organization): bool
    {
        // Only admins can delete organizations
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Only admins can create organizations
        return $user->role === 'admin';
    }
}
