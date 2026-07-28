<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;

abstract class BaseResource extends Resource
{
    /**
     * Check if authenticated user has one of the given roles.
     */
    protected static function hasRoles(array $roles): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // Super Admin selalu boleh
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return $user->hasAnyRole($roles);
    }

    /**
     * Check if authenticated user has a specific role.
     */
    protected static function hasRole(string $role): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // Super Admin selalu boleh
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return $user->hasRole($role);
    }

    /**
     * Untuk nanti saat menggunakan Permission.
     */
    protected static function hasPermission(string $permission): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole('super-admin')) {
            return true;
        }

        return $user->can($permission);
    }
}