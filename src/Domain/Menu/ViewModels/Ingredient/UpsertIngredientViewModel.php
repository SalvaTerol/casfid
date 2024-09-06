<?php

namespace Domain\Menu\ViewModels\Ingredient;

use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\Models\Ingredient;
use Domain\Shared\ViewModels\ViewModel;

class UpsertIngredientViewModel extends ViewModel
{
    public function __construct(public readonly ?Ingredient $ingredient = null) {}

    public function ingredient(): ?IngredientData
    {
        if (! $this->ingredient) {
            return null;
        }

        return IngredientData::fromModel($this->ingredient);
    }
}
