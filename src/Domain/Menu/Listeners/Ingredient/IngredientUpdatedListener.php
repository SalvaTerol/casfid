<?php

namespace Domain\Menu\Listeners\Ingredient;

use Domain\Menu\Actions\Ingredient\ResetCacheIngredientAction;
use Domain\Menu\Actions\Pizza\UpsertPizzaAction;
use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\Events\Ingredient\IngredientUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class IngredientUpdatedListener implements ShouldQueue
{
    public function handle(IngredientUpdatedEvent $event): void
    {
        ResetCacheIngredientAction::execute();

        $event->pizzas->each(function ($pizza) {
            UpsertPizzaAction::execute(PizzaData::fromModel($pizza), $pizza);
        });
    }
}
