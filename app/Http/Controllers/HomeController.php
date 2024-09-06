<?php

namespace App\Http\Controllers;

use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        $viewModel = new GetPizzasViewModel(request()->get('page', 1));

        return view('home', ['viewModel' => $viewModel]);
    }
}
