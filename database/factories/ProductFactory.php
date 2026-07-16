<?php

namespace Database\Factories;

use App\Models\Boutique;
use App\Models\Product;
use App\Models\User;
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
            'status' => Product::STATUS_APPROVED,
            'submitted_by' => User::factory(),
        ];
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Product::STATUS_PENDING,
            'is_active' => false,
        ]);
    }

    public function approved(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Product::STATUS_APPROVED,
            'is_active' => true,
        ]);
    }

    public function rejected(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Product::STATUS_REJECTED,
            'is_active' => false,
        ]);
    }
}
