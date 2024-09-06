<?php

namespace Domain\Menu\Actions\Ingredient;

use Domain\Menu\Events\Ingredient\IngredientUpdatedEvent;
use Domain\Menu\Models\Ingredient;
use Illuminate\Support\Facades\DB;

class DeleteIngredientAction
{
    public static function execute(Ingredient $ingredient): mixed
    {
        return DB::transaction(function () use ($ingredient) {
            event(new IngredientUpdatedEvent($ingredient->pizzas));
            $ingredient->delete();
        });

    }
}
