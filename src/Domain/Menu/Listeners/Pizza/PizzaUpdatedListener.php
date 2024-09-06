<?php

namespace Domain\Menu\Listeners\Pizza;

use Domain\Menu\Actions\Pizza\ResetCachePizzaAction;
use Domain\Menu\Events\Pizza\PizzaUpdatedEvent;
use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

class PizzaUpdatedListener implements ShouldQueue
{
    public function handle(PizzaUpdatedEvent $event): void
    {
        ResetCachePizzaAction::execute();
    }
}
