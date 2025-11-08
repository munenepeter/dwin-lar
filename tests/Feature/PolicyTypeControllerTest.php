<?php

namespace Tests\Feature;

use App\Models\PolicyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\PolicyTypeController
 */
class PolicyTypeControllerTest extends TestCase
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
    public function it_can_display_the_policy_types_index_page()
    {
        PolicyType::factory()->count(3)->create();

        $response = $this->get(route('policy-types.index'));

        $response->assertOk();
        $response->assertViewIs('policy-types.index');
        $this->assertCount(3, $response->viewData('policyTypes'));
    }

    /**
     * @test
     */
    public function it_can_display_the_create_policy_type_form()
    {
        $response = $this->get(route('policy-types.create'));

        $response->assertOk();
        $response->assertViewIs('policy-types.create');
    }

    /**
     * @test
     */
    public function it_can_store_a_new_policy_type()
    {
        $policyTypeData = PolicyType::factory()->make()->toArray();

        $response = $this->post(route('policy-types.store'), $policyTypeData);

        $response->assertRedirect(route('policy-types.index'));
        $this->assertDatabaseHas('policy_types', ['type_name' => $policyTypeData['type_name']]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_policy_type()
    {
        $policyType = PolicyType::factory()->create();

        $response = $this->get(route('policy-types.show', $policyType));

        $response->assertOk();
        $response->assertViewIs('policy-types.show');
        $response->assertSee($policyType->type_name);
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_policy_type_form()
    {
        $policyType = PolicyType::factory()->create();

        $response = $this->get(route('policy-types.edit', $policyType));

        $response->assertOk();
        $response->assertViewIs('policy-types.edit');
        $response->assertSee($policyType->type_name);
    }

    /**
     * @test
     */
    public function it_can_update_a_policy_type()
    {
        $policyType = PolicyType::factory()->create();
        $updateData = PolicyType::factory()->make()->toArray();

        $response = $this->put(route('policy-types.update', $policyType), $updateData);

        $response->assertRedirect(route('policy-types.index'));
        $this->assertDatabaseHas('policy_types', ['id' => $policyType->id, 'type_name' => $updateData['type_name']]);
    }

    /**
     * @test
     */
    public function it_can_delete_a_policy_type()
    {
        $policyType = PolicyType::factory()->create();

        $response = $this->delete(route('policy-types.destroy', $policyType));

        $response->assertRedirect(route('policy-types.index'));
        $this->assertDatabaseMissing('policy_types', ['id' => $policyType->id]);
    }
}
