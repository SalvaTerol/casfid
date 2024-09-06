<?php

namespace Database\Factories\Menu;

use Domain\Menu\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = Ingredient::class;

    public function definition()
    {
        $ingredients = [
            'Tomato Sauce',
            'Cheese',
            'Pepperoni',
            'Mushrooms',
            'Onions',
            'Olives',
            'Green Peppers',
            'Ham',
            'Pineapple',
            'Bacon'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($ingredients),
            'price' => $this->faker->randomFloat(2, 0.50, 5.00),
        ];
    }
}
