<?php

namespace App\Providers;

use App\Policies\IngredientPolicy;
use App\Policies\PizzaPolicy;
use Domain\Menu\Events\Ingredient\IngredientCreatedEvent;
use Domain\Menu\Events\Ingredient\IngredientUpdatedEvent;
use Domain\Menu\Events\Pizza\PizzaCreatedEvent;
use Domain\Menu\Events\Pizza\PizzaUpdatedEvent;
use Domain\Menu\Listeners\Ingredient\IngredientCreatedListener;
use Domain\Menu\Listeners\Ingredient\IngredientUpdatedListener;
use Domain\Menu\Listeners\Pizza\PizzaCreatedListener;
use Domain\Menu\Listeners\Pizza\PizzaUpdatedListener;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
                PizzaUpdatedEvent::class,
                PizzaUpdatedListener::class
        );
        Event::listen(
            PizzaCreatedEvent::class,
            PizzaCreatedListener::class
        );
        Event::listen(
            IngredientUpdatedEvent::class,
            IngredientUpdatedListener::class
        );
        Event::listen(
            IngredientCreatedEvent::class,
            IngredientCreatedListener::class
        );

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->is_admin;
        });
        Gate::policy(Pizza::class, PizzaPolicy::class);
        Gate::policy(Ingredient::class, IngredientPolicy::class);
    }
}
