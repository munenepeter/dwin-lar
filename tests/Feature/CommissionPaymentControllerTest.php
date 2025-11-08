<?php

namespace Tests\Feature;

use App\Models\CommissionPayment;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\CommissionPaymentController
 */
class CommissionPaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * @test
     */
    public function it_can_display_the_commission_payments_index_page()
    {
        CommissionPayment::factory()->count(3)->create();

        $response = $this->get(route('commission-payments.index'));

        $response->assertOk();
        $response->assertViewIs('commission-payments.index');
        $this->assertCount(3, $response->viewData('commissionPayments'));
    }

    /**
     * @test
     */
    public function it_can_display_the_create_commission_payment_form()
    {
        $response = $this->get(route('commission-payments.create'));

        $response->assertOk();
        $response->assertViewIs('commission-payments.create');
    }

    /**
     * @test
     */
    public function it_can_store_a_new_commission_payment()
    {
        $policy = Policy::factory()->create();
        $paymentData = CommissionPayment::factory()->make(['policy_id' => $policy->id])->toArray();

        $response = $this->post(route('commission-payments.store'), $paymentData);

        $response->assertRedirect(route('commission-payments.index'));
        $this->assertDatabaseHas('commission_payments', ['policy_id' => $policy->id]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_commission_payment()
    {
        $payment = CommissionPayment::factory()->create();

        $response = $this->get(route('commission-payments.show', $payment));

        $response->assertOk();
        $response->assertViewIs('commission-payments.show');
        $response->assertSee(e($payment->payment_date->format('Y-m-d')));
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_commission_payment_form()
    {
        $payment = CommissionPayment::factory()->create();

        $response = $this->get(route('commission-payments.edit', $payment));

        $response->assertOk();
        $response->assertViewIs('commission-payments.edit');
        $response->assertSee(e($payment->payment_date->format('Y-m-d')));
    }

    /**
     * @test
     */
    public function it_can_update_a_commission_payment()
    {
        $payment = CommissionPayment::factory()->create();
        $updateData = CommissionPayment::factory()->make()->toArray();

        $response = $this->put(route('commission-payments.update', $payment), $updateData);

        $response->assertRedirect(route('commission-payments.index'));
        $this->assertDatabaseHas('commission_payments', ['id' => $payment->id, 'total_commission_amount' => $updateData['total_commission_amount']]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_commission_payment()
    {
        $payment = CommissionPayment::factory()->create();

        $response = $this->delete(route('commission-payments.destroy', $payment));

        $response->assertRedirect(route('commission-payments.index'));
        $this->assertDatabaseMissing('commission_payments', ['id' => $payment->id]);
    }
}
