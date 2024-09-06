<?php

namespace Database\Seeders;

use Domain\Menu\Models\Ingredient;
use Domain\Menu\Models\Pizza;
use Domain\Shared\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $ingredients = Ingredient::factory()->count(10)->create();

        $pizzaImages = ['pizza-alternative.webp', 'pizza-alternative-2.webp', 'pizza-default.webp'];

        foreach ($pizzaImages as $image) {
            $sourcePath = resource_path("images/{$image}");
            $targetPath = "{$image}";

            if (! Storage::disk('public')->exists($targetPath)) {
                Storage::disk('public')->put($targetPath, file_get_contents($sourcePath));
            }

            if (file_exists($sourcePath)) {
                unlink($sourcePath);
            }
        }

        Pizza::factory()->count(20)->create()->each(function ($pizza) use ($ingredients) {
            $randomIngredients = $ingredients->random(rand(2, 5))->pluck('id');
            $pizza->ingredients()->attach($randomIngredients);

            $totalPriceIngredients = $pizza->ingredients->sum(function ($ingredient) {
                return $ingredient->price->euro;
            });

            $totalPrice = $totalPriceIngredients * 1.50;

            $pizza->update([
                'total_price' => (int) round($totalPrice),
            ]);
        });

        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('QWERTY123'),
        ]);

        User::factory()->create([
            'name' => 'casfid',
            'email' => 'client@client.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
