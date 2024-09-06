<?php

namespace App\Http\Api;

use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;

class ListPizzaController
{
    public function __invoke()
    {
        return (new GetPizzasViewModel(request()->get('page', 1)))->pizzas();
    }
}
