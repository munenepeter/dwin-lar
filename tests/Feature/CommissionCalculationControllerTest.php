<?php

namespace Tests\Feature;

use App\Models\CommissionCalculation;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\CommissionCalculationController
 */
class CommissionCalculationControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        // The stored procedure is not available in sqlite, so we need to create it for testing
        DB::unprepared('CREATE TRIGGER `calculate_commission_on_policy_creation` AFTER INSERT ON `policies` FOR EACH ROW
        BEGIN
            CALL CalculateCommission(NEW.id, @p_commission_amount, @p_calculation_id);
        END');
        DB::unprepared('DROP PROCEDURE IF EXISTS CalculateCommission');
        DB::unprepared('CREATE PROCEDURE CalculateCommission(IN p_policy_id INT, OUT p_commission_amount DECIMAL(10, 2), OUT p_calculation_id INT)
        BEGIN
            -- Implementation of the procedure is not needed for this test, as we are only testing the controller
            SET p_commission_amount = 100.00;
            SET p_calculation_id = 1;
        END');

    }

    /**
     * @test
     */
    public function it_can_display_the_commission_calculations_index_page()
    {
        $response = $this->get(route('commission-calculations.index'));

        $response->assertOk();
        $response->assertViewIs('commission-calculations.index');
    }

    /**
     * @test
     */
    public function it_can_display_the_create_commission_calculation_form()
    {
        $response = $this->get(route('commission-calculations.create'));

        $response->assertOk();
        $response->assertViewIs('commission-calculations.create');
    }

    /**
     * @test
     */
    public function it_can_store_a_commission_calculation()
    {
        $policy = Policy::factory()->create();

        $response = $this->post(route('commission-calculations.store'), ['policy_id' => $policy->id]);

        $response->assertRedirect(route('commission-calculations.index'));
        $response->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function it_can_display_a_single_commission_calculation()
    {
        $calculation = CommissionCalculation::factory()->create();

        $response = $this->get(route('commission-calculations.show', $calculation));

        $response->assertOk();
        $response->assertViewIs('commission-calculations.show');
        $response->assertSee(e($calculation->commission_amount));
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_commission_calculation_form()
    {
        $calculation = CommissionCalculation::factory()->create();

        $response = $this->get(route('commission-calculations.edit', $calculation));

        $response->assertOk();
        $response->assertViewIs('commission-calculations.edit');
        $response->assertSee(e($calculation->commission_amount));
    }

    /**
     * @test
     */
    public function it_can_update_a_commission_calculation()
    {
        $calculation = CommissionCalculation::factory()->create();
        $company = InsuranceCompany::factory()->create();

        $updateData = [
            'policy_id' => $calculation->policy_id,
            'agent_id' => $calculation->agent_id,
            'company_id' => $company->id,
            'commission_rate' => 0.15,
            'commission_amount' => 150.00,
            'calculation_date' => now()->format('Y-m-d'),
            'payment_status' => 'Paid',
        ];

        $response = $this->put(route('commission-calculations.update', $calculation), $updateData);

        $response->assertRedirect(route('commission-calculations.index'));
        $this->assertDatabaseHas('commission_calculations', ['id' => $calculation->id, 'commission_amount' => 150.00]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_commission_calculation()
    {
        $calculation = CommissionCalculation::factory()->create();

        $response = $this->delete(route('commission-calculations.destroy', $calculation));

        $response->assertRedirect(route('commission-calculations.index'));
        $this->assertDatabaseMissing('commission_calculations', ['id' => $calculation->id]);
    }
}
