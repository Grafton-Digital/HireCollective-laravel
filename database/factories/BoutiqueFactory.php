<?php

namespace Database\Factories;

use App\Models\Boutique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Boutique>
 */
class BoutiqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraphs(2, true),
            'city' => fake()->city(),
            'county' => fake()->state(),
            'contact_email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'is_active' => true,
        ];
    }
}
