<?php

namespace App\Http\Controllers;

use Domain\Menu\Actions\Ingredient\DeleteIngredientAction;
use Domain\Menu\Actions\Ingredient\UpsertIngredientAction;
use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\FormRequests\IngredientRequest;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\ViewModels\Ingredient\GetIngredientViewModel;
use Domain\Menu\ViewModels\Ingredient\UpsertIngredientViewModel;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $viewModel = new GetIngredientViewModel(request()->get('page', 1));

        return view('ingredients.index', ['viewModel' => $viewModel]);
    }

    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Ingredient::class)) {
            abort(403);
        }
        return view('ingredients.form');
    }

    public function store(IngredientRequest $ingredientRequest)
    {
        if ($ingredientRequest->user()->cannot('create', Ingredient::class)) {
            abort(403);
        }
        $data = IngredientData::fromRequest($ingredientRequest);
        UpsertIngredientAction::execute($data);

        return redirect()->route('ingredients.index')->with('success', __('menu.ingredient_created'));
    }

    public function show(Ingredient $ingredient)
    {
        return view('ingredients.show', new UpsertIngredientViewModel($ingredient));
    }

    public function edit(Ingredient $ingredient, Request $request)
    {
        if ($request->user()->cannot('update', $ingredient)) {
            abort(403);
        }
        return view('ingredients.form', new UpsertIngredientViewModel($ingredient));
    }

    public function update(IngredientRequest $ingredientRequest, Ingredient $ingredient)
    {
        if ($ingredientRequest->user()->cannot('update', $ingredient)) {
            abort(403);
        }
        $data = IngredientData::fromRequest($ingredientRequest, $ingredient->id);
        UpsertIngredientAction::execute($data, $ingredient);

        return redirect()->route('ingredients.show', $ingredient->id)->with('success', __('menu.ingredient_updated'));
    }

    public function destroy(Ingredient $ingredient, Request $request)
    {
        if ($request->user()->cannot('delete', $ingredient)) {
            abort(403);
        }
        DeleteIngredientAction::execute($ingredient);
        return redirect()->route('ingredients.index')->with('success', __('menu.ingredient_deleted'));
    }
}
