<?php

namespace Database\Factories;

use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommissionStructure>
 */
class CommissionStructureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => InsuranceCompany::factory(),
            'policy_type_id' => PolicyType::factory(),
            'structure_name' => $this->faker->word,
            'commission_type' => 'FLAT_PERCENTAGE',
            'base_percentage' => $this->faker->randomFloat(2, 5, 20),
            'effective_date' => now(),
            'is_active' => true,
        ];
    }
}
