<?php

namespace Tests\Feature;

use Domain\Shared\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_route_is_accessible()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_pizzas_route_requires_admin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('pizzas.index'));
        $response->assertStatus(403);

        $user->is_admin = true;
        $user->save();

        $response = $this->actingAs($user)->get(route('pizzas.index'));
        $response->assertStatus(200);
    }

    public function test_ingredients_route_requires_admin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('ingredients.index'));
        $response->assertStatus(403);

        $user->is_admin = true;
        $user->save();

        $response = $this->actingAs($user)->get(route('ingredients.index'));
        $response->assertStatus(200);
    }
}
