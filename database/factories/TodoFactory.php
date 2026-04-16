<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'notes' => fake()->optional()->sentence(10),
            'is_done' => fake()->boolean(),
            'status' => fake()->randomElement(['pending', 'in_progress', 'done']),
            'due_at' => fake()->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
