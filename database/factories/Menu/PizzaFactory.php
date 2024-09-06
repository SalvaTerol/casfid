<?php

namespace Database\Factories\Menu;

use Domain\Menu\Models\Pizza;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaFactory extends Factory
{
    protected $model = Pizza::class;

    public function definition()
    {
        $pizzaNames = [
            'Margherita',
            'Pepperoni',
            'Hawaiian',
            'Veggie',
            'BBQ Chicken',
            'Meat Lovers',
            'Four Cheese',
            'Supreme',
            'Buffalo Chicken',
            'Mushroom Delight',
            'Mexican',
            'Cheeseburger',
            'Italian Classic',
            'Spicy Chicken',
            'Seafood Special',
            'Mediterranean',
            'Taco Fiesta',
            'Pesto Delight',
            'Bacon Ranch',
            'Garlic Lover',
            'Sicilian',
            'Philly Cheesesteak',
            'Truffle Mushroom',
            'Greek Style',
            'Smokey Bacon',
            'Chicken Alfredo',
            'Caramelized Onion',
            'Carbonara',
            'Sausage Fest',
            'Vegan Delight'
        ];

        $pizzaImages = ['pizza-alternative.webp', 'pizza-alternative-2.webp', 'pizza-default.webp'];

        return [
            'name' => $this->faker->unique()->randomElement($pizzaNames),
            'image' => $this->faker->randomElement($pizzaImages),
            'total_price' => 0,
        ];
    }
}
