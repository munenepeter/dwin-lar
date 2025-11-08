<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\CommissionCalculation;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\PolicyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\DashboardController
 */
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        
        // The stored procedure is not available in sqlite, so we need to create it for testing
        DB::unprepared('DROP PROCEDURE IF EXISTS GetExpiringPoliciesReport');
        DB::unprepared('CREATE PROCEDURE GetExpiringPoliciesReport(IN p_days INT)
        BEGIN
            SELECT COUNT(*) as count FROM policies WHERE DATEDIFF(expiry_date, NOW()) BETWEEN 0 AND p_days;
        END');
    }

    /**
     * @test
     */
    public function it_can_display_the_dashboard_with_correct_data()
    {
        // 1. Total Number of Clients
        Client::factory()->count(5)->create();

        // 2. Total Number of Active Policies
        Policy::factory()->count(3)->create(['policy_status' => 'ACTIVE']);
        Policy::factory()->count(2)->create(['policy_status' => 'INACTIVE']);

        // 3. Total Premium Amount (Year-to-Date)
        Policy::factory()->create(['premium_amount' => 1000, 'created_at' => now()]);
        Policy::factory()->create(['premium_amount' => 1500, 'created_at' => now()]);
        Policy::factory()->create(['premium_amount' => 500, 'created_at' => now()->subYear()]);

        // 4. Total Commission Earned (Year-to-Date - Paid Commissions)
        CommissionCalculation::factory()->create(['commission_amount' => 200, 'payment_status' => 'PAID', 'created_at' => now()]);
        CommissionCalculation::factory()->create(['commission_amount' => 300, 'payment_status' => 'PAID', 'created_at' => now()]);
        CommissionCalculation::factory()->create(['commission_amount' => 100, 'payment_status' => 'UNPAID', 'created_at' => now()]);

        // 5. Number of Policies Expiring Soon is mocked by the SP

        // 6. Policy Distribution by Type
        $policyType1 = PolicyType::factory()->create(['type_name' => 'Health']);
        $policyType2 = PolicyType::factory()->create(['type_name' => 'Life']);
        Policy::factory()->create(['policy_type_id' => $policyType1->id]);
        Policy::factory()->create(['policy_type_id' => $policyType1->id]);
        Policy::factory()->create(['policy_type_id' => $policyType2->id]);

        // 7. Policy Distribution by Company
        $company1 = InsuranceCompany::factory()->create(['company_name' => 'Aetna']);
        $company2 = InsuranceCompany::factory()->create(['company_name' => 'Cigna']);
        Policy::factory()->create(['company_id' => $company1->id]);
        Policy::factory()->create(['company_id' => $company2->id]);
        Policy::factory()->create(['company_id' => $company2->id]);


        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertViewHasAll([
            'totalClients',
            'activePolicies',
            'yearToDatePremium',
            'yearToDateCommission',
            'expiringPolicies',
            'policyTypeLabels',
            'policyTypeData',
            'policyCompanyLabels',
            'policyCompanyData',
        ]);

        $this->assertEquals(5, $response->viewData('totalClients'));
        $this->assertEquals(3, $response->viewData('activePolicies'));
        $this->assertEquals(2500, $response->viewData('yearToDatePremium'));
        $this->assertEquals(500, $response->viewData('yearToDateCommission'));
    }
}
