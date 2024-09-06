<?php

namespace Domain\Menu\Actions\Pizza;

use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\Models\Pizza;

class CalculateTotalPriceAction
{
    public static function execute(?PizzaData $data = null, ?Pizza $pizza = null, $force = false): bool|float
    {
        $totalIngredients = $data->ingredients->sum(function ($ingredient) {
            return $ingredient->price->euro;
        });

        return $totalIngredients * 1.5;
    }
}
