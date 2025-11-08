<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_code' => $this->faker->unique()->numerify('CL-####'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'id_number' => $this->faker->unique()->numerify('########'),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['MALE', 'FEMALE', 'OTHER']),
            'email' => $this->faker->unique()->safeEmail,
            'phone_primary' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'assigned_agent_id' => User::factory(),
            'client_status' => 'ACTIVE',
            'kyc_status' => 'VERIFIED',
        ];
    }
}
