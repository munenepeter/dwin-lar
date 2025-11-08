<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Client;
use App\Models\PolicyType;
use App\Models\InsuranceCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Policy>
 */
class PolicyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'policy_number' => $this->faker->unique()->numerify('POL-########'),
            'client_id' => Client::factory(),
            'company_id' => InsuranceCompany::factory(),
            'policy_type_id' => PolicyType::factory(),
            'agent_id' => User::factory(),
            'policy_status' => $this->faker->randomElement(['ACTIVE', 'EXPIRED', 'CANCELLED', 'PENDING']),
            'premium_amount' => $this->faker->randomFloat(2, 100, 5000),
            'sum_insured' => $this->faker->randomFloat(2, 10000, 1000000),
            'issue_date' => $this->faker->date(),
            'effective_date' => $this->faker->date(),
            'expiry_date' => $this->faker->dateTimeBetween('+1 year', '+5 years'),
            'payment_frequency' => $this->faker->randomElement(['MONTHLY', 'QUARTERLY', 'SEMI_ANNUAL', 'ANNUAL']),
        ];
    }
}
