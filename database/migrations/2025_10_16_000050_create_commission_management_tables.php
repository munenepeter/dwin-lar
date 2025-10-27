<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('commission_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('company_id')->constrained('insurance_companies')->restrictOnDelete();
            $table->foreignId('commission_structure_id')->constrained('commission_structures')->restrictOnDelete();
            $table->date('calculation_date');
            $table->decimal('premium_amount', 12, 2);
            $table->decimal('commission_rate', 5, 2);
            $table->decimal('commission_amount', 10, 2);
            $table->enum('calculation_method', ['FLAT_PERCENTAGE', 'TIERED', 'FIXED_AMOUNT']);
            $table->json('calculation_details')->nullable();
            $table->enum('payment_status', ['PENDING', 'PAID', 'CANCELLED'])->default('PENDING');
            $table->date('payment_date')->nullable();
            $table->string('payment_reference', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('commission_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_batch_number', 50)->unique();
            $table->foreignId('agent_id')->constrained('users')->restrictOnDelete();
            $table->date('payment_period_start');
            $table->date('payment_period_end');
            $table->decimal('total_commission_amount', 12, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['BANK_TRANSFER', 'CHEQUE', 'CASH', 'MOBILE_MONEY']);
            $table->string('payment_reference', 100)->nullable();
            $table->json('bank_details')->nullable();
            $table->enum('status', ['PENDING', 'PROCESSED', 'FAILED', 'CANCELLED'])->default('PENDING');
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('commission_payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_payment_id')->constrained('commission_payments')->cascadeOnDelete();
            $table->foreignId('commission_calculation_id')->constrained('commission_calculations')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['commission_payment_id', 'commission_calculation_id'], 'uk_comm_payment_calc');
        });
    }

    public function down(): void {
        Schema::dropIfExists('commission_payment_items');
        Schema::dropIfExists('commission_payments');
        Schema::dropIfExists('commission_calculations');
    }
};
