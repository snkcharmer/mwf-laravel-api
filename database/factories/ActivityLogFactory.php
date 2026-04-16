<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'     => fake()->randomNumber(5),
            'action'      => fake()->randomElement(['created', 'updated', 'deleted', 'login']),
            'entity_type' => fake()->randomElement(['Branch', 'Company', 'Product']),
            'entity_id'   => fake()->randomNumber(5),
            'description' => fake()->sentence(),
            'metadata'    => [
                'ip_address' => fake()->ipv4(),
                'browser'    => fake()->userAgent(),
            ],
        ];
    }
}
