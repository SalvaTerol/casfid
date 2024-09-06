<?php

namespace Domain\Menu\Listeners\Pizza;

use Domain\Menu\Actions\Pizza\ResetCachePizzaAction;
use Domain\Menu\Events\Pizza\PizzaCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class PizzaCreatedListener implements ShouldQueue
{
    public function handle(PizzaCreatedEvent $event): void
    {
        ResetCachePizzaAction::execute();
    }
}
