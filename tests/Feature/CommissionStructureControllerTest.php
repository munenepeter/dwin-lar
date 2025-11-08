<?php

namespace Tests\Feature;

use App\Models\CommissionStructure;
use App\Models\InsuranceCompany;
use App\Models\PolicyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\CommissionStructureController
 */
class CommissionStructureControllerTest extends TestCase
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
    public function it_can_display_the_commission_structures_index_page()
    {
        CommissionStructure::factory()->count(3)->create();

        $response = $this->get(route('commission-structures.index'));

        $response->assertOk();
        $response->assertViewIs('commission-structures.index');
        $this->assertCount(3, $response->viewData('commissionStructures'));
    }

    /**
     * @test
     */
    public function it_can_display_the_create_commission_structure_form()
    {
        $response = $this->get(route('commission-structures.create'));

        $response->assertOk();
        $response->assertViewIs('commission-structures.form');
    }

    /**
     * @test
     */
    public function it_can_store_a_new_commission_structure()
    {
        $company = InsuranceCompany::factory()->create();
        $policyType = PolicyType::factory()->create();
        
        $structureData = [
            'company_id' => $company->id,
            'policy_type_id' => $policyType->id,
            'commission_rate' => 0.10,
            'effective_date' => now()->format('Y-m-d'),
            'end_date' => now()->addYear()->format('Y-m-d'),
        ];

        $response = $this->post(route('commission-structures.store'), $structureData);

        $response->assertRedirect(route('commission-structures.index'));
        $this->assertDatabaseHas('commission_structures', ['company_id' => $company->id]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_commission_structure()
    {
        $structure = CommissionStructure::factory()->create();

        $response = $this->get(route('commission-structures.show', $structure));

        $response->assertOk();
        $response->assertViewIs('commission-structures.show');
        $response->assertSee(e($structure->commission_rate));
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_commission_structure_form()
    {
        $structure = CommissionStructure::factory()->create();

        $response = $this->get(route('commission-structures.edit', $structure));

        $response->assertOk();
        $response->assertViewIs('commission-structures.form');
        $response->assertSee(e($structure->commission_rate));
    }

    /**
     * @test
     */
    public function it_can_update_a_commission_structure()
    {
        $structure = CommissionStructure::factory()->create();
        $updateData = CommissionStructure::factory()->make()->toArray();

        $response = $this->put(route('commission-structures.update', $structure), $updateData);

        $response->assertRedirect(route('commission-structures.index'));
        $this->assertDatabaseHas('commission_structures', ['id' => $structure->id, 'commission_rate' => $updateData['commission_rate']]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_commission_structure()
    {
        $structure = CommissionStructure::factory()->create();

        $response = $this->delete(route('commission-structures.destroy', $structure));

        $response->assertRedirect(route('commission-structures.index'));
        $this->assertDatabaseMissing('commission_structures', ['id' => $structure->id]);
    }
}
