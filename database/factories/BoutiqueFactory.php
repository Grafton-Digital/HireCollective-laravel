<?php

namespace Database\Factories;

use App\County;
use App\Models\Boutique;
use App\Models\User;
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
            'county' => fake()->randomElement(County::cases())->value,
            'contact_email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'is_active' => true,
            'status' => Boutique::STATUS_APPROVED,
            'submitted_by' => User::factory(),
        ];
    }

    public function pending(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Boutique::STATUS_PENDING,
            'is_active' => false,
        ]);
    }

    public function approved(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Boutique::STATUS_APPROVED,
            'is_active' => true,
        ]);
    }

    public function rejected(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => Boutique::STATUS_REJECTED,
            'is_active' => false,
        ]);
    }
}
