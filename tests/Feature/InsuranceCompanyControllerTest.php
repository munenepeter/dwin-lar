<?php

namespace Tests\Feature;

use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\InsuranceCompanyController
 */
class InsuranceCompanyControllerTest extends TestCase
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
    public function it_can_display_the_insurance_companies_index_page()
    {
        InsuranceCompany::factory()->count(3)->create();

        $response = $this->get(route('insurance-companies.index'));

        $response->assertOk();
        $response->assertViewIs('insurance-companies.index');
        $this->assertCount(3, $response->viewData('insuranceCompanies'));
    }

    /**
     * @test
     */
    public function it_can_display_the_create_insurance_company_form()
    {
        $response = $this->get(route('insurance-companies.create'));

        $response->assertOk();
        $response->assertViewIs('insurance-companies.create');
    }

    /**
     * @test
     */
    public function it_can_store_a_new_insurance_company()
    {
        $companyData = InsuranceCompany::factory()->make()->toArray();

        $response = $this->post(route('insurance-companies.store'), $companyData);

        $response->assertRedirect(route('insurance-companies.index'));
        $this->assertDatabaseHas('insurance_companies', ['company_name' => $companyData['company_name']]);
    }

    /**
     * @test
     */
    public function it_can_display_a_single_insurance_company()
    {
        $company = InsuranceCompany::factory()->create();

        $response = $this->get(route('insurance-companies.show', $company));

        $response->assertOk();
        $response->assertViewIs('insurance-companies.show');
        $response->assertSee($company->company_name);
    }

    /**
     * @test
     */
    public function it_can_display_the_edit_insurance_company_form()
    {
        $company = InsuranceCompany::factory()->create();

        $response = $this->get(route('insurance-companies.edit', $company));

        $response->assertOk();
        $response->assertViewIs('insurance-companies.edit');
        $response->assertSee($company->company_name);
    }

    /**
     * @test
     */
    public function it_can_update_an_insurance_company()
    {
        $company = InsuranceCompany::factory()->create();
        $updateData = InsuranceCompany::factory()->make()->toArray();

        $response = $this->put(route('insurance-companies.update', $company), $updateData);

        $response->assertRedirect(route('insurance-companies.index'));
        $this->assertDatabaseHas('insurance_companies', ['id' => $company->id, 'company_name' => $updateData['company_name']]);
    }

    /**
     * @test
     */
    public function it_can_delete_an_insurance_company()
    {
        $company = InsuranceCompany::factory()->create();

        $response = $this->delete(route('insurance-companies.destroy', $company));

        $response->assertRedirect(route('insurance-companies.index'));
        $this->assertDatabaseMissing('insurance_companies', ['id' => $company->id]);
    }

    /**
     * @test
     */
    public function it_can_return_company_stats_as_json()
    {
        InsuranceCompany::factory()->count(5)->create(['is_active' => true]);
        InsuranceCompany::factory()->count(2)->create(['is_active' => false]);
        Policy::factory()->count(10)->create(['premium_amount' => 100]);

        $response = $this->getJson(route('insurance-companies.stats'));

        $response->assertOk();
        $response->assertJson([
            'total_companies' => 7,
            'active_companies' => 5,
            'total_policies' => 10,
        ]);
    }
}
