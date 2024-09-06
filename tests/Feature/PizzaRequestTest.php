<?php

namespace Tests\Feature;

use Domain\Menu\FormRequests\PizzaRequest;
use Domain\Menu\Models\Ingredient;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class PizzaRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_pizza_requires_name()
    {
        $data = [
            'image' => 'pizza.jpg',
            'ingredients' => [],
        ];

        $this->assertFalse($this->validateRequest($data));
    }

    public function test_pizza_requires_image()
    {
        $data = [
            'name' => 'Margherita',
            'ingredients' => [],
        ];

        $this->assertFalse($this->validateRequest($data));
    }

    public function test_pizza_requires_valid_ingredients()
    {
        $data = [
            'name' => 'Margherita',
            'image' => 'pizza.jpg',
            'ingredients' => 'invalid',
        ];

        $this->assertFalse($this->validateRequest($data));
    }

    public function test_pizza_validation_passes_with_valid_data()
    {
        $ingredient1 = Ingredient::factory()->create(['name' => 'Cheese', 'price' => 2.0]);
        $ingredient2 = Ingredient::factory()->create(['name' => 'Pepperoni', 'price' => 3.0]);

        $file = UploadedFile::fake()->image('pizza.jpg', 400, 400);

        $data = [
            'name' => 'Margherita',
            'image' => $file,
            'ingredients' => [$ingredient1->id, $ingredient2->id],
        ];

        $this->assertTrue($this->validateRequest($data));
    }



    private function validateRequest(array $data)
    {
        $request = new PizzaRequest();
        $validator = Validator::make($data, $request->rules());

        return !$validator->fails();
    }
}
