<?php

namespace Tests\Feature;

use Tests\TestCase;
use Domain\Shared\Models\User;
use Domain\Menu\Models\Ingredient;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_ingredient()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post(route('ingredients.store'), [
            'name' => 'Tomato',
            'price' => 1.5,
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->post(route('ingredients.store'), [
            'name' => 'Tomato',
            'price' => 1.5,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('ingredients.index'));
    }

    public function test_ingredient_update_policy_is_enforced()
    {
        $ingredient = Ingredient::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->put(route('ingredients.update', $ingredient->id), [
            'name' => 'Updated Tomato',
            'price' => 2.0,
        ]);
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->put(route('ingredients.update', $ingredient->id), [
            'name' => 'Updated Tomato',
            'price' => 2.0,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('ingredients.show', $ingredient->id));
    }

    public function test_only_admin_can_delete_ingredient()
    {
        $ingredient = Ingredient::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($user)->delete(route('ingredients.destroy', $ingredient->id));
        $response->assertStatus(403);

        $response = $this->actingAs($admin)->delete(route('ingredients.destroy', $ingredient->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('ingredients.index'));
    }
}
