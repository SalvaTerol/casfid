<?php

namespace Domain\Menu\Builders\Pizza;

use Illuminate\Database\Eloquent\Builder;

class PizzaBuilder extends Builder
{
    public function getPizzasWithIngredientsPaginated(int $perPage, int $currentPage)
    {
        return $this->with('ingredients')
            ->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
