<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use App\Models\Client;
use App\Models\Policy;
use App\Models\InsuranceCompany;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_get_routes_return_a_successful_response()
    {
        $this->actingAs(User::factory()->create());

        $routes = [
            '/',
            '/about',
            '/products',
            '/contact',
            '/blog',
            '/dashboard',
            '/settings/profile',
            '/settings/password',
            '/settings/appearance',
            '/admin/dashboard',
            '/admin/analytics',
            '/admin/user-roles',
            '/admin/users',
            '/admin/insurance-companies',
            '/admin/policy-types',
            '/admin/commission-structures',
            '/admin/clients',
            '/admin/policies',
            '/admin/commission-calculations',
            '/admin/commission-payments',
            '/admin/notifications',
            '/admin/performance-metrics',
            '/admin/system-settings',
            '/admin/audit-logs',
            '/admin/maintenance',
            '/reports/agent-performance',
            '/reports/financial-reports',
            '/reports/expiring-policies',
            '/register',
            '/login',
            '/forgot-password',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }

        // Routes that require a model
        $client = Client::factory()->create();
        $policy = Policy::factory()->create();
        $insuranceCompany = InsuranceCompany::factory()->create();
        
        $modelRoutes = [
            '/admin/clients/' . $client->id,
            '/admin/policies/' . $policy->id,
            '/admin/insurance-companies/' . $insuranceCompany->id,
        ];
        
        foreach ($modelRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }
}
