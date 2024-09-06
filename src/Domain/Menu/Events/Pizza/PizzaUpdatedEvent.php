<?php

namespace Domain\Menu\Events\Pizza;

use Domain\Menu\Models\Pizza;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PizzaUpdatedEvent
{
    use Dispatchable, SerializesModels;
    public function __construct()
    {
    }
}
