<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('insurance_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100)->unique();
            $table->string('company_code', 20)->unique();
            $table->string('contact_person', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 50)->default('Kenya');
            $table->string('website', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['company_code', 'is_active']);
        });

        Schema::create('policy_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name', 50)->unique();
            $table->string('type_code', 20)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type_code']);
        });

        Schema::create('commission_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('insurance_companies')->cascadeOnDelete();
            $table->foreignId('policy_type_id')->constrained('policy_types')->cascadeOnDelete();
            $table->string('structure_name', 100);
            $table->enum('commission_type', ['FLAT_PERCENTAGE', 'TIERED', 'FIXED_AMOUNT']);
            $table->decimal('base_percentage', 5, 2)->nullable();
            $table->decimal('fixed_amount', 10, 2)->nullable();
            $table->json('tier_structure')->nullable();
            $table->decimal('minimum_premium', 10, 2)->default(0);
            $table->decimal('maximum_premium', 10, 2)->nullable();
            $table->date('effective_date');
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // short custom name to avoid MySQL identifier length limit
            $table->unique(['company_id', 'policy_type_id', 'effective_date'], 'uk_commission_structure');
        });
    }

    public function down(): void {
        Schema::dropIfExists('commission_structures');
        Schema::dropIfExists('policy_types');
        Schema::dropIfExists('insurance_companies');
    }
};
