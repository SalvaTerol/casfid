<?php

namespace App\Policies;

use Domain\Menu\Models\Pizza;
use Domain\Shared\Models\User;

class PizzaPolicy
{
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Pizza $pizza): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Pizza $pizza): bool
    {
        return $user->is_admin;
    }
}
