<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AuditLog>
 */
class AuditLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'table_name' => $this->faker->word,
            'record_id' => $this->faker->randomNumber(),
            'action_type' => $this->faker->randomElement(['INSERT', 'UPDATE', 'DELETE']),
            'user_id' => User::factory(),
        ];
    }
}
