<?php

namespace Domain\Menu\ViewModels\Pizza;

use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Domain\Shared\ViewModels\ViewModel;
use Illuminate\Support\Facades\Cache;

class UpsertPizzaViewModel extends ViewModel
{
    public function __construct(public readonly ?Pizza $pizza = null)
    {
    }

    public function pizza(): ?PizzaData
    {
        if (!$this->pizza){
            return null;
        }

        return PizzaData::fromModel($this->pizza->load('ingredients'));
    }

    public function ingredients()
    {
        return Cache::rememberForever('ingredients_list', function () {
            return Ingredient::all()->map(fn(Ingredient $ingredient) => IngredientData::fromModel($ingredient));
        });
    }


}
