<?php

namespace Database\Factories;

use App\Models\Policy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PolicyRenewal>
 */
class PolicyRenewalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'original_policy_id' => Policy::factory(),
            'renewal_date' => now(),
            'old_premium_amount' => $this->faker->randomFloat(2, 100, 5000),
            'new_premium_amount' => $this->faker->randomFloat(2, 100, 5000),
            'renewal_status' => 'COMPLETED',
            'agent_id' => User::factory(),
        ];
    }
}
