<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CommissionPayment>
 */
class CommissionPaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'payment_batch_number' => $this->faker->unique()->numerify('BATCH-########'),
            'agent_id' => User::factory(),
            'payment_period_start' => now()->startOfMonth(),
            'payment_period_end' => now()->endOfMonth(),
            'total_commission_amount' => $this->faker->randomFloat(2, 500, 10000),
            'payment_date' => now(),
            'payment_method' => 'BANK_TRANSFER',
            'status' => 'PROCESSED',
        ];
    }
}
