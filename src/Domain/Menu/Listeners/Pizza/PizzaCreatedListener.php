<?php

namespace Domain\Menu\Listeners\Pizza;

use Domain\Menu\Actions\Pizza\ResetCachePizzaAction;
use Domain\Menu\Events\Pizza\PizzaCreatedEvent;
use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class PizzaCreatedListener implements ShouldQueue
{
    public function handle(PizzaCreatedEvent $event): void
    {
        ResetCachePizzaAction::execute();
    }
}
