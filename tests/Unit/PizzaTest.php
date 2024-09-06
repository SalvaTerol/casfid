<?php

namespace Tests\Unit;

use Domain\Menu\Actions\Pizza\DeletePizzaAction;
use Domain\Menu\DataTransferObject\IngredientData;
use Domain\Menu\Models\Pizza;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Actions\Pizza\UpsertPizzaAction;
use Domain\Menu\DataTransferObject\PizzaData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PizzaTest extends TestCase
{
    use RefreshDatabase;

    public function test_pizza_can_be_created_using_action()
    {
        $pizzaData = PizzaData::fromArray([
            'name' => 'Margherita',
            'image' => 'margherita.jpg',
            'ingredients' => [],
        ]);

        $pizza = (new UpsertPizzaAction())->execute($pizzaData);

        $this->assertDatabaseHas('pizzas', [
            'name' => 'Margherita',
            'image' => 'margherita.jpg',
        ]);
    }

    public function test_pizza_can_have_ingredients_using_action()
    {
        $ingredient1 = Ingredient::create(['name' => 'Cheese', 'price' => 2.0]);
        $ingredient2 = Ingredient::create(['name' => 'Pepperoni', 'price' => 3.0]);

        $pizzaData = PizzaData::fromArray([
            'name' => 'Pepperoni Pizza',
            'image' => 'pepperoni.jpg',
            'ingredients' => [$ingredient1->id, $ingredient2->id],
        ]);

        $pizza = (new UpsertPizzaAction())->execute($pizzaData);

        $this->assertCount(2, $pizza->ingredients);
        $this->assertTrue($pizza->ingredients->contains($ingredient1));
        $this->assertTrue($pizza->ingredients->contains($ingredient2));
    }

    public function test_pizza_cost_is_calculated_correctly_using_action()
    {
        $ingredient1 = Ingredient::create(['name' => 'Cheese', 'price' => 2.0]);
        $ingredient2 = Ingredient::create(['name' => 'Pepperoni', 'price' => 3.0]);

        $pizzaData = PizzaData::fromArray([
            'name' => 'Pepperoni Pizza',
            'image' => 'pepperoni.jpg',
            'ingredients' => [$ingredient1->id, $ingredient2->id],
        ]);

        $pizza = (new UpsertPizzaAction())->execute($pizzaData);

        $calculatedCost = $pizza->ingredients->sum(function ($ingredient) {
                return $ingredient->price->euro;
            }) * 1.5;

        $this->assertEquals(7.5, $calculatedCost);
    }

    public function test_pizza_can_be_deleted_using_action()
    {
        $pizzaData = PizzaData::fromArray([
            'name' => 'Hawaiian',
            'image' => 'hawaiian.jpg',
            'ingredients' => [],
        ]);

        $pizza = (new UpsertPizzaAction())->execute($pizzaData);
        (new DeletePizzaAction())->execute($pizza);

        $this->assertDatabaseMissing('pizzas', ['name' => 'Hawaiian']);
    }

    public function test_pizza_image_can_be_uploaded_using_action()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('pizza.jpg');

        $pizzaData = PizzaData::fromArray([
            'name' => 'Four Seasons',
            'image' => $file,
            'ingredients' => [],
        ]);

        $pizza = (new UpsertPizzaAction())->execute($pizzaData);
        Storage::disk('public')->assertExists($file->hashName());

        $this->assertDatabaseHas('pizzas', ['name' => 'Four Seasons', 'image' => $file->hashName()]);
    }
}
