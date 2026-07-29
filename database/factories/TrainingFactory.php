<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'video_path' => 'trainings/videos/sample.mp4',
            'thumbnail_path' => null,
            'sort_order' => fake()->numberBetween(0, 100),
            'is_published' => true,
        ];
    }
}
