<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ad $ad): bool
    {
       return $ad->status === 'active' || optional($user)?->id === $ad->user_id
            || optional($user)?->isAdmin();;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return $user->isAdmin() || $user->role === 'user';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ad): bool
    {
        return $user->id === $ad->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ad $ad): bool
    {
         return $user->id === $ad->user_id || $user->isAdmin();
    }

    // Determin wheathwe the admin will aprove on the ad
        public function approve(User $user, Ad $ad): bool
    {
        return $user->isAdmin();
    }

    public function reject(User $user, Ad $ad): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ad $ad): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ad $ad): bool
    {
        return false;
    }
}
