<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\AnalyticsController
 */
class AnalyticsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_render_the_analytics_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.analytics'));

        $response->assertOk();
        $response->assertViewIs('analytics.index');
    }

    /**
     * @test
     */
    public function it_loads_all_required_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.analytics'));

        $response->assertOk();
        $response->assertViewHasAll([
            'totalClients',
            'totalPolicies',
            'totalPremium',
            'totalCommissions',
            'clientAcquisition',
            'clientStatus',
            'policiesSold',
            'premiumGrowth',
            'policyStatusDistribution',
            'expiringPolicies',
            'commissionsEarned',
            'topAgents',
            'commissionsByCompany',
        ]);
    }
}
