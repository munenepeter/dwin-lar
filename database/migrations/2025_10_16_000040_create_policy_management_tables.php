<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('policy_number', 50)->unique();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->foreignId('company_id')->constrained('insurance_companies')->restrictOnDelete();
            $table->foreignId('policy_type_id')->constrained('policy_types')->restrictOnDelete();
            $table->foreignId('agent_id')->constrained('users')->restrictOnDelete();
            $table->enum('policy_status', ['ACTIVE', 'EXPIRED', 'CANCELLED', 'SUSPENDED', 'PENDING'])->default('PENDING');
            $table->decimal('premium_amount', 12, 2);
            $table->decimal('sum_insured', 15, 2);
            $table->json('coverage_details')->nullable();
            $table->date('issue_date');
            $table->date('effective_date');
            $table->date('expiry_date');
            $table->enum('payment_frequency', ['MONTHLY', 'QUARTERLY', 'SEMI_ANNUAL', 'ANNUAL']);
            $table->enum('payment_method', ['CASH', 'CHEQUE', 'BANK_TRANSFER', 'MOBILE_MONEY', 'CARD'])->default('CASH');
            $table->boolean('renewal_notice_sent')->default(false);
            $table->timestamp('renewal_notice_date')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('policy_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('new_policy_id')->nullable()->constrained('policies')->nullOnDelete();
            $table->date('renewal_date');
            $table->decimal('old_premium_amount', 12, 2);
            $table->decimal('new_premium_amount', 12, 2);
            $table->enum('renewal_status', ['PENDING', 'COMPLETED', 'DECLINED', 'LAPSED'])->default('PENDING');
            $table->foreignId('agent_id')->constrained('users')->restrictOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('policy_renewals');
        Schema::dropIfExists('policies');
    }
};
