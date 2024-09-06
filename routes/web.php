<?php

use App\Http\Controllers\ChangeLocaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PizzaController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('locale/{locale}', ChangeLocaleController::class)->name('locale')->middleware(\App\Http\Middleware\ValidateLocale::class);
Route::middleware(SetLocale::class)->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::middleware(IsAdmin::class)->group(function () {
        Route::resource('pizzas', PizzaController::class);
        Route::resource('ingredients', IngredientController::class);
    });
});

Auth::routes();

