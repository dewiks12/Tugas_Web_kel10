<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployee() || $user->isCustomer();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEmployee()) {
            return $transaction->branch_id === $user->branch_id;
        }

        if ($user->isCustomer()) {
            return $transaction->customer_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEmployee();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEmployee()) {
            return $transaction->branch_id === $user->branch_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEmployee()) {
            return $transaction->branch_id === $user->branch_id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return $user->isAdmin();
    }
}
