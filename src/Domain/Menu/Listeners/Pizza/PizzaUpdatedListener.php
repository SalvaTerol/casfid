<?php

namespace Domain\Menu\Listeners\Pizza;

use Domain\Menu\Actions\Pizza\ResetCachePizzaAction;
use Domain\Menu\Events\Pizza\PizzaUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class PizzaUpdatedListener implements ShouldQueue
{
    public function handle(PizzaUpdatedEvent $event): void
    {
        ResetCachePizzaAction::execute();
    }
}
