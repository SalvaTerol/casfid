<?php

namespace Domain\Menu\Builders\Ingredient;

use Illuminate\Database\Eloquent\Builder;

class IngredientBuilder extends Builder
{
    public function getIngredientsPaginated(int $perPage, int $currentPage)
    {
        return $this->orderBy('name')
            ->paginate($perPage, ['*'], 'page', $currentPage);
    }
}
