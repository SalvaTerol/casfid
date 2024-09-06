<?php

namespace App\Http\Controllers;

use Domain\Menu\Actions\Pizza\DeletePizzaAction;
use Domain\Menu\Actions\Pizza\UpsertPizzaAction;
use Domain\Menu\DataTransferObject\PizzaData;
use Domain\Menu\FormRequests\PizzaRequest;
use Domain\Menu\Models\Pizza;
use Domain\Menu\ViewModels\Pizza\GetPizzasViewModel;
use Domain\Menu\ViewModels\Pizza\UpsertPizzaViewModel;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    public function index()
    {
        $viewModel = new GetPizzasViewModel(request()->get('page', 1));

        return view('pizzas.index', ['viewModel' => $viewModel]);
    }

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Pizza::class)) {
            abort(403);
        }

        return view('pizzas.form', new UpsertPizzaViewModel);
    }

    public function store(PizzaRequest $pizzaRequest)
    {
        if ($pizzaRequest->user()->cannot('create', Pizza::class)) {
            abort(403);
        }
        $data = PizzaData::fromRequest($pizzaRequest);
        UpsertPizzaAction::execute($data);

        return redirect()->route('pizzas.index')->with('success', __('menu.pizza_created'));
    }

    public function show(Pizza $pizza)
    {
        return view('pizzas.show', new UpsertPizzaViewModel($pizza));
    }

    public function edit(Pizza $pizza, Request $request)
    {
        if ($request->user()->cannot('update', $pizza)) {
            abort(403);
        }

        return view('pizzas.form', new UpsertPizzaViewModel($pizza));
    }

    public function update(PizzaRequest $pizzaRequest, Pizza $pizza)
    {
        if ($pizzaRequest->user()->cannot('update', $pizza)) {
            abort(403);
        }
        $data = PizzaData::fromRequest($pizzaRequest, $pizza->id);
        UpsertPizzaAction::execute($data, $pizza);

        return redirect()->route('pizzas.show', $pizza->id)->with('success', __('menu.pizza_updated'));
    }

    public function destroy(Pizza $pizza, Request $request)
    {
        if ($request->user()->cannot('delete', $pizza)) {
            abort(403);
        }
        DeletePizzaAction::execute($pizza);

        return redirect()->route('pizzas.index')->with('success', __('menu.pizza_deleted'));
    }
}
