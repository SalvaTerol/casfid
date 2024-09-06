<?php

namespace Domain\Menu\Listeners\Ingredient;

use Domain\Menu\Actions\Ingredient\ResetCacheIngredientAction;
use Domain\Menu\Events\Ingredient\IngredientCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class IngredientCreatedListener implements ShouldQueue
{
    public function handle(IngredientCreatedEvent $event): void
    {
        ResetCacheIngredientAction::execute();
    }
}
