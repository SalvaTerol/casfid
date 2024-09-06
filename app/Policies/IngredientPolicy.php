<?php

namespace App\Policies;

use Domain\Menu\Models\Ingredient;
use Domain\Shared\Models\User;

class IngredientPolicy
{
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Ingredient $ingredient): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Ingredient $ingredient): bool
    {
        return $user->is_admin;
    }
}
