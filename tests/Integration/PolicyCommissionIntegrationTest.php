<?php

namespace Tests\Integration;

use App\Models\Client;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\PolicyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PolicyCommissionIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->actingAs($user);

        DB::unprepared('DROP PROCEDURE IF EXISTS CalculateCommission');
        DB::unprepared("CREATE PROCEDURE CalculateCommission(IN p_policy_id INT, OUT p_commission_amount DECIMAL(10, 2), OUT p_calculation_id INT)
        BEGIN
            DECLARE v_premium DECIMAL(10, 2);
            DECLARE v_rate DECIMAL(5, 2);

            SELECT premium_amount INTO v_premium FROM policies WHERE id = p_policy_id;
            SET v_rate = 0.10; -- Mocked commission rate of 10%
            SET p_commission_amount = v_premium * v_rate;

            INSERT INTO commission_calculations (policy_id, commission_amount, calculation_date) VALUES (p_policy_id, p_commission_amount, NOW());
            SET p_calculation_id = LAST_INSERT_ID();
        END");
    }

    /**
     * @test
     */
    public function creating_a_policy_triggers_a_commission_calculation()
    {
        // Given
        $client = Client::factory()->create();
        $company = InsuranceCompany::factory()->create();
        $policyType = PolicyType::factory()->create(['type_code' => 'LIFE']);
        $agent = User::factory()->create();

        $policyData = [
            'client_id' => $client->id,
            'company_id' => $company->id,
            'policy_type_id' => $policyType->id,
            'premium_amount' => 2000.00,
            'agent_id' => $agent->id,
            'policy_status' => 'ACTIVE',
            'issue_date' => now(),
            'effective_date' => now(),
            'expiry_date' => now()->addYear(),
        ];

        // When
        $response = $this->post(route('policies.store'), $policyData);

        // Then
        $response->assertRedirect(route('policies.index'));

        $policy = Policy::first();
        $this->assertDatabaseHas('commission_calculations', [
            'policy_id' => $policy->id,
            'commission_amount' => 200.00, // 10% of 2000.00
        ]);
    }
}
