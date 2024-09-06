<?php

namespace Domain\Menu\Events\Ingredient;

use Domain\Menu\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IngredientUpdatedEvent
{
    use Dispatchable, SerializesModels;
    public function __construct(public readonly Collection $pizzas)
    {
    }
}
