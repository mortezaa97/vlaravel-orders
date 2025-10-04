<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Policies;

use App\Models\User;
use Mortezaa97\Orders\Models\PayType;

class PayTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PayType $payType): bool
    {
        return $user->id === $payType->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PayType $payType): bool
    {
        return $user->id === $payType->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PayType $payType): bool
    {
        return $user->id === $payType->created_by || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PayType $payType): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PayType $payType): bool
    {
        return $user->hasRole('admin');
    }
}
