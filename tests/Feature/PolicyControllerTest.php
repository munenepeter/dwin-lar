<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Policy;
use App\Models\AuditLog;
use App\Models\PolicyType;
use App\Models\InsuranceCompany;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\PolicyController
 */
class PolicyControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        
        // Mock the stored procedures required by the controller/model events for testing purposes.
        // These are assumed to be present in the MySQL database.
        DB::unprepared('DROP PROCEDURE IF EXISTS CalculateCommission');
        DB::unprepared('CREATE PROCEDURE CalculateCommission(IN p_policy_id INT, OUT p_commission_amount DECIMAL(10, 2), OUT p_calculation_id INT)
        BEGIN
            -- Mock implementation for testing
            SET p_commission_amount = 100.00;
            SET p_calculation_id = 1;
        END');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateExpiredPolicies');
        DB::unprepared('CREATE PROCEDURE UpdateExpiredPolicies()
        BEGIN
            UPDATE policies SET policy_status = \'EXPIRED\' WHERE expiry_date < NOW();
        END');
    }

    /**
     * @test
     */
    public function it_can_display_the_policies_index_page()
    {
        Policy::factory()->count(5)->create();
        $response = $this->get(route('policies.index'));

        $response->assertOk();
        $response->assertViewIs('policies.index');
        $this->assertCount(5, $response->viewData('policies'));
    }

    /**
     * @test
     */
    public function it_can_display_the_create_policy_form()
    {
        $response = $this->get(route('policies.create'));

        $response->assertOk();
        $response->assertViewIs('policies.forms._policy_form');
    }
    
    /**
     * @test
     */
    public function it_can_get_policy_types_by_company()
    {
        $company = InsuranceCompany::factory()->create();
        $policyType = PolicyType::factory()->create();
        $company->commissionStructures()->create([
            'policy_type_id' => $policyType->id,
            'commission_rate' => 0.10,
            'effective_date' => now(),
        ]);

        $response = $this->getJson(route('policy-types.by-company', $company->id));

        $response->assertOk();
        $response->assertJson([['id' => $policyType->id, 'type_name' => $policyType->type_name]]);
    }

    /**
     * @test
     */
    public function it_can_store_a_new_policy()
    {
        $client = Client::factory()->create();
        $company = InsuranceCompany::factory()->create();
        $policyType = PolicyType::factory()->create(['type_code' => 'TEST']);
        $agent = User::factory()->create();

        $policyData = Policy::factory()->make([
            'client_id' => $client->id,
            'company_id' => $company->id,
            'policy_type_id' => $policyType->id,
            'agent_id' => $agent->id,
        ])->toArray();

        $response = $this->post(route('policies.store'), $policyData);

        $response->assertRedirect(route('policies.index'));
        $this->assertDatabaseHas('policies', ['client_id' => $client->id]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_policy()
    {
        $policy = Policy::factory()->create();
        AuditLog::factory()->create([
            'table_name' => 'policies',
            'record_id' => $policy->id,
        ]);

        $response = $this->get(route('policies.show', $policy->id));

        $response->assertOk();
        $response->assertViewIs('policies.forms._policy_details');
        $response->assertSee($policy->policy_number);
        $this->assertCount(1, $response->viewData('auditLog'));
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_policy_form()
    {
        $policy = Policy::factory()->create();
        $response = $this->get(route('policies.edit', $policy->id));

        $response->assertOk();
        $response->assertViewIs('policies.forms._policy_form');
        $response->assertSee($policy->policy_number);
    }

    /**
     * @test
     */
    public function it_can_update_a_policy()
    {
        $policy = Policy::factory()->create();
        $updateData = Policy::factory()->make()->toArray();

        $response = $this->put(route('policies.update', $policy->id), $updateData);

        $response->assertRedirect(route('policies.index'));
        $this->assertDatabaseHas('policies', ['id' => $policy->id, 'policy_number' => $updateData['policy_number']]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_policy()
    {
        $policy = Policy::factory()->create();
        $response = $this->delete(route('policies.destroy', $policy->id));

        $response->assertRedirect(route('policies.index'));
        $this->assertDatabaseMissing('policies', ['id' => $policy->id]);
    }

    /**
     * @test
     */
    public function it_can_update_expired_policies()
    {
        Policy::factory()->create(['expiry_date' => now()->subDay(), 'policy_status' => 'ACTIVE']);
        $response = $this->post(route('policies.updateExpired'));

        $response->assertRedirect(route('policies.index'));
        $this->assertDatabaseHas('policies', ['policy_status' => 'EXPIRED']);
    }
}
