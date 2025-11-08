<?php

namespace Database\Factories;

use App\Models\CommissionStructure;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommissionCalculation>
 */
class CommissionCalculationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'policy_id' => Policy::factory(),
            'agent_id' => User::factory(),
            'company_id' => InsuranceCompany::factory(),
            'commission_structure_id' => CommissionStructure::factory(),
            'calculation_date' => now(),
            'premium_amount' => $this->faker->randomFloat(2, 100, 5000),
            'commission_rate' => $this->faker->randomFloat(2, 5, 20),
            'commission_amount' => $this->faker->randomFloat(2, 10, 1000),
            'calculation_method' => 'FLAT_PERCENTAGE',
        ];
    }
}
