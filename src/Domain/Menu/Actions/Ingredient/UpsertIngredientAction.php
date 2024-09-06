<?php

namespace Domain\Menu\Actions\Ingredient;

use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\Events\Ingredient\IngredientCreatedEvent;
use Domain\Menu\Events\Ingredient\IngredientUpdatedEvent;
use Domain\Menu\Models\Ingredient;
use Illuminate\Support\Facades\DB;

class UpsertIngredientAction
{
    public static function execute(IngredientData $data): Ingredient
    {
        return DB::transaction(function () use ($data) {
            $ingredient = Ingredient::updateOrCreate([
                'id' => $data->id,
            ], [
                'name' => $data->name,
                'price' => $data->price,
            ]);

            if ($ingredient->wasRecentlyCreated) {
                event(new IngredientCreatedEvent);
            }

            if ($ingredient->wasChanged()) {
                event(new IngredientUpdatedEvent($ingredient->pizzas));
            }

            return $ingredient;
        });

    }
}
