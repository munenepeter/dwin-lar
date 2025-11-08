<?php

namespace Tests\Unit;

use App\Models\Policy;
use App\Models\PolicyType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @covers \App\Models\Policy
 */
class PolicyModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_generates_a_policy_number_correctly_for_the_first_policy_of_a_type_in_a_year()
    {
        // Given
        $policyType = PolicyType::factory()->create(['type_code' => 'AUTO']);
        $year = now()->year;
        $policy = new Policy();

        // When
        $policyNumber = $policy->generatePolicyNumber($policyType->type_code);

        // Then
        $this->assertEquals("AUTO-{$year}-0001", $policyNumber);
    }

    /**
     * @test
     */
    public function it_increments_the_policy_number_counter_correctly()
    {
        // Given
        $policyType = PolicyType::factory()->create(['type_code' => 'HOME']);
        $year = now()->year;
        Policy::factory()->create([
            'policy_type_id' => $policyType->id,
            'policy_number' => "HOME-{$year}-0042"
        ]);
        $policy = new Policy();


        // When
        $policyNumber = $policy->generatePolicyNumber($policyType->type_code);

        // Then
        $this->assertEquals("HOME-{$year}-0043", $policyNumber);
    }
}
