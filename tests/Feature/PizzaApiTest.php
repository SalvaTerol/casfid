<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Domain\Menu\Models\Pizza;
use Domain\Menu\Models\Ingredient;

class PizzaApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_pizzas_as_json()
    {
        $ingredient1 = Ingredient::factory()->create(['name' => 'Tomato', 'price' => 1.0]);
        $ingredient2 = Ingredient::factory()->create(['name' => 'Cheese', 'price' => 1.5]);

        $pizza = Pizza::factory()->create(['name' => 'Margherita']);
        $pizza->ingredients()->attach([$ingredient1->id, $ingredient2->id]);

        $response = $this->getJson('/api/pizzas');

        $response->assertStatus(200);

        // Caracter especial NBSP para el espacio en los precios formateados
        $nbsp = "\u{00A0}";

        $response->assertJson([
            'data' => [
                [
                    'name' => 'Margherita',
                    'ingredients' => [
                        [
                            'name' => 'Tomato',
                            'price' => [
                                'cent' => 100,
                                'euro' => 1,
                                'formatted' => "1,00{$nbsp}€",
                            ],
                        ],
                        [
                            'name' => 'Cheese',
                            'price' => [
                                'cent' => 150,
                                'euro' => 1.5,
                                'formatted' => "1,50{$nbsp}€",
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
