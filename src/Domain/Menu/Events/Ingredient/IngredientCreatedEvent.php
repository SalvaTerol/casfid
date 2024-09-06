<?php

namespace Domain\Menu\Events\Ingredient;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientCreatedEvent
{
    use Dispatchable, SerializesModels;
    public function __construct()
    {
    }
}
