<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_code', 20)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('id_number', 20)->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER'])->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone_primary', 20);
            $table->string('phone_secondary', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('county', 50)->nullable();
            $table->string('country', 50)->default('Kenya');
            $table->string('occupation', 100)->nullable();
            $table->string('employer', 100)->nullable();
            $table->decimal('annual_income', 12, 2)->nullable();
            $table->enum('marital_status', ['SINGLE', 'MARRIED', 'DIVORCED', 'WIDOWED'])->nullable();
            $table->string('next_of_kin', 100)->nullable();
            $table->string('next_of_kin_phone', 20)->nullable();
            $table->string('next_of_kin_relationship', 50)->nullable();
            $table->foreignId('assigned_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('client_status', ['ACTIVE', 'INACTIVE', 'SUSPENDED'])->default('ACTIVE');
            $table->enum('kyc_status', ['PENDING', 'VERIFIED', 'REJECTED'])->default('PENDING');
            $table->timestamp('kyc_verified_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->string('full_name', 101)->virtualAs("concat(first_name, ' ', last_name)");

            $table->index(['client_code', 'id_number', 'phone_primary']);
        });

        Schema::create('client_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->enum('document_type', [
                'ID_COPY',
                'PASSPORT_COPY',
                'KRA_PIN',
                'PROOF_OF_INCOME',
                'BANK_STATEMENT',
                'OTHER'
            ]);
            $table->string('document_name', 255);
            $table->string('file_path', 500);
            $table->integer('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('client_documents');
        Schema::dropIfExists('clients');
    }
};
