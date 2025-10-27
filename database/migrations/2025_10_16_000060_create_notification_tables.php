<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('notification_type', [
                'POLICY_EXPIRY',
                'RENEWAL_DUE',
                'COMMISSION_READY',
                'KYC_PENDING',
                'PAYMENT_DUE',
                'SYSTEM_ALERT'
            ]);
            $table->string('title', 255);
            $table->text('message');
            $table->foreignId('target_user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('target_role_id')->nullable()->constrained('user_roles')->cascadeOnDelete();
            $table->string('related_table', 64)->nullable();
            $table->unsignedBigInteger('related_record_id')->nullable();
            $table->enum('priority', ['LOW', 'MEDIUM', 'HIGH', 'URGENT'])->default('MEDIUM');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_sent')->default(false);
            $table->boolean('send_email')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('sms_sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
