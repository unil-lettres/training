<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Request;
use App\User;

class RequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Request $request): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Request $request): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Request $request): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Request $request): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Request $request): bool
    {
        return $user->hasRole(
            [strtolower(UserRole::ADMIN->name), strtolower(UserRole::SUPER_EDITOR->name)]
        );
    }
}
