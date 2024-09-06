<?php

namespace Domain\Menu\Events\Pizza;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PizzaCreatedEvent
{
    use Dispatchable, SerializesModels;

    public function __construct() {}
}
