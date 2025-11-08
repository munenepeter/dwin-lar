<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRole>
 */
class UserRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_name' => $this->faker->unique()->jobTitle,
            'description' => $this->faker->sentence,
            'permissions' => json_encode(['read' => true, 'write' => false]),
            'is_active' => true,
        ];
    }
}
