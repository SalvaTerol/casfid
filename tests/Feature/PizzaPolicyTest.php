<?php

namespace Tests\Feature;

use Tests\TestCase;
use Domain\Shared\Models\User;
use Domain\Menu\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PizzaPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_pizza()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('pizzas.store'), [
            'name' => 'Margherita',
            'image' => 'pizza.jpg',
            'ingredients' => [],
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->post(route('pizzas.store'), [
            'name' => 'Margherita',
            'image' => 'pizza.jpg',
            'ingredients' => [],
        ]);
        $response->assertStatus(302);
    }

    public function test_only_admin_can_update_pizza()
    {
        $pizza = Pizza::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->put(route('pizzas.update', $pizza->id), [
            'name' => 'Updated Margherita',
            'image' => 'pizza_updated.jpg',
            'ingredients' => [],
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->put(route('pizzas.update', $pizza->id), [
            'name' => 'Updated Margherita',
            'image' => 'pizza_updated.jpg',
            'ingredients' => [],
        ]);
        $response->assertStatus(302);
    }

    public function test_only_admin_can_delete_pizza()
    {
        $pizza = Pizza::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->delete(route('pizzas.destroy', $pizza));
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->delete(route('pizzas.destroy', $pizza));
        $response->assertStatus(302);
    }
}
