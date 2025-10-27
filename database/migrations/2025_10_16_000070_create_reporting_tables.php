<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('metric_date');
            $table->foreignId('agent_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('insurance_companies')->cascadeOnDelete();
            $table->foreignId('policy_type_id')->nullable()->constrained('policy_types')->cascadeOnDelete();
            $table->integer('total_policies_sold')->default(0);
            $table->decimal('total_premium_amount', 15, 2)->default(0);
            $table->decimal('total_commission_earned', 12, 2)->default(0);
            $table->decimal('average_policy_value', 12, 2)->default(0);
            $table->decimal('renewal_rate', 5, 2)->default(0);
            $table->integer('client_acquisition_count')->default(0);
            $table->timestamps();

            $table->unique(['metric_date', 'agent_id', 'company_id', 'policy_type_id'], 'uk_metric_date_agent_company_policy_type');
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value');
            $table->enum('setting_type', ['STRING', 'INTEGER', 'DECIMAL', 'BOOLEAN', 'JSON'])->default('STRING');
            $table->text('description')->nullable();
            $table->boolean('is_system_setting')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('performance_metrics');
    }
};
