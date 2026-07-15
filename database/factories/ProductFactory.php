<?php

namespace Database\Factories;

use App\Models\Boutique;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $designers = ['Gucci', 'Prada', 'Chanel', 'Dior', 'Versace', 'Armani', 'Valentino', 'Dolce & Gabbana'];

        return [
            'boutique_id' => Boutique::factory(),
            'name' => fake()->words(3, true),
            'designer' => fake()->randomElement($designers),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'is_variable' => false,
            'price' => fake()->randomFloat(2, 50, 200),
            'is_available' => true,
            'is_active' => true,
        ];
    }
}
