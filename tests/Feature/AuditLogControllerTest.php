<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\AuditLogController
 */
class AuditLogControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_render_the_audit_log_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.audit-logs'));

        $response->assertOk();
        $response->assertViewIs('admin.audit-logs.index');
    }

    /**
     * @test
     */
    public function it_can_filter_audit_logs()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        // Create some audit logs
        DB::table('audit_log')->insert([
            ['user_id' => $user->id, 'table_name' => 'clients', 'action' => 'created', 'old_data' => '{}', 'new_data' => '{}', 'created_at' => now()],
            ['user_id' => $anotherUser->id, 'table_name' => 'policies', 'action' => 'updated', 'old_data' => '{}', 'new_data' => '{}', 'created_at' => now()->subDay()],
        ]);

        $response = $this->actingAs($user)->get(route('admin.audit-logs', ['user_id' => $user->id]));
        $response->assertOk();
        $response->assertSee($user->full_name);
        $response->assertDontSee($anotherUser->full_name);

        $response = $this->actingAs($user)->get(route('admin.audit-logs', ['table_name' => 'clients']));
        $response->assertOk();
        $response->assertSee('clients');
        $response->assertDontSee('policies');

        $response = $this->actingAs($user)->get(route('admin.audit-logs', ['date_from' => now()->subDay()]));
        $response->assertOk();

        $response = $this->actingAs($user)->get(route('admin.audit-logs', ['date_to' => now()->subDay()]));
        $response->assertOk();
    }
}
