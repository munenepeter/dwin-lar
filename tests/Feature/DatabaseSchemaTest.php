<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Models\User;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_expected_tables_are_created_by_migrations()
    {
        $this->actingAs(User::factory()->create());
        // The RefreshDatabase trait handles the migrations, so if this test runs, migrations are working.
        // We can add explicit checks for key tables to be more thorough.

        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('password_reset_tokens'));
        $this->assertTrue(Schema::hasTable('failed_jobs'));
        $this->assertTrue(Schema::hasTable('jobs'));
        $this->assertTrue(Schema::hasTable('cache'));
        $this->assertTrue(Schema::hasTable('sessions'));

        // Application specific tables
        $this->assertTrue(Schema::hasTable('audit_logs'));
        $this->assertTrue(Schema::hasTable('insurance_companies'));
        $this->assertTrue(Schema::hasTable('commission_structures'));
        $this->assertTrue(Schema::hasTable('clients'));
        $this->assertTrue(Schema::hasTable('client_documents'));
        $this->assertTrue(Schema::hasTable('policy_types'));
        $this->assertTrue(Schema::hasTable('policies'));
        $this->assertTrue(Schema::hasTable('policy_renewals'));
        $this->assertTrue(Schema::hasTable('commission_calculations'));
        $this->assertTrue(Schema::hasTable('commission_payments'));
        $this->assertTrue(Schema::hasTable('commission_payment_items'));
        $this->assertTrue(Schema::hasTable('notifications'));
        $this->assertTrue(Schema::hasTable('performance_metrics'));
        $this->assertTrue(Schema::hasTable('system_settings'));
        $this->assertTrue(Schema::hasTable('user_roles'));
    }
}
