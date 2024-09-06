<?php

namespace Tests\Unit;

use Domain\Menu\Builders\Ingredient\IngredientBuilder;
use Domain\Shared\Models\Casts\PriceCast;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Domain\Menu\Actions\Ingredient\UpsertIngredientAction;
use Domain\Menu\Actions\Ingredient\DeleteIngredientAction;
use Domain\Menu\DataTransferObject\IngredientData;
use Illuminate\Validation\ValidationException;

class IngredientTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_ingredient_using_an_action()
    {
        $ingredientData = IngredientData::fromArray([
            'name' => 'Tomato',
            'price' => 1.5,
        ]);

        $ingredient = (new UpsertIngredientAction())->execute($ingredientData);

        $this->assertDatabaseHas('ingredients', [
            'name' => $ingredient->name,
            'price' => $ingredient->price->cent,
        ]);
    }

    public function test_it_can_update_an_ingredient_using_an_action()
    {
        $ingredientData = IngredientData::fromArray([
            'name' => 'Cheese',
            'price' => 2.0,
        ]);
        $ingredient = (new UpsertIngredientAction())->execute($ingredientData);

        $updatedIngredientData = IngredientData::fromArray([
            'name' => 'Cheese',
            'price' => 2.5,
        ]);
        $updatedIngredient = (new UpsertIngredientAction())->execute($updatedIngredientData, $ingredient);

        $this->assertDatabaseHas('ingredients', [
            'name' => $updatedIngredient->name,
            'price' => $updatedIngredient->price->cent,
        ]);
    }

    public function test_it_can_delete_an_ingredient_using_an_action()
    {
        $ingredientData = IngredientData::fromArray([
            'name' => 'Pepperoni',
            'price' => 2.0,
        ]);
        $ingredient = (new UpsertIngredientAction())->execute($ingredientData);

        (new DeleteIngredientAction())->execute($ingredient);

        $this->assertDatabaseMissing('ingredients', [
            'name' => $ingredient->name,
        ]);
    }

    public function test_the_price_is_cast_correctly()
    {
        $ingredientData = IngredientData::fromArray([
            'name' => 'Mushroom',
            'price' => 2.0,
        ]);

        $ingredient = (new UpsertIngredientAction())->execute($ingredientData);

        $this->assertEquals(200, $ingredient->getAttributes()['price']);
    }

    public function test_an_ingredient_can_belong_to_many_pizzas()
    {
        $ingredientData = IngredientData::fromArray([
            'name' => 'Cheese',
            'price' => 2.0,
        ]);
        $ingredient = (new UpsertIngredientAction())->execute($ingredientData);

        $pizza1 = Pizza::create(['name' => 'Margarita']);
        $pizza2 = Pizza::create(['name' => 'Pepperoni']);

        $pizza1->ingredients()->attach($ingredient->id);
        $pizza2->ingredients()->attach($ingredient->id);

        $this->assertCount(2, $ingredient->pizzas);
        $this->assertTrue($ingredient->pizzas->contains($pizza1));
        $this->assertTrue($ingredient->pizzas->contains($pizza2));
    }

    public function test_it_uses_custom_builder()
    {
        $ingredient = new Ingredient();
        $this->assertInstanceOf(IngredientBuilder::class, $ingredient->newQuery());
    }
}
