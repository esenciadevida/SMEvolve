<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_sessions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->string('session_id', 80)->index();
            $table->string('status', 20)->default('started')->index();
            $table->integer('current_step')->default(1);
            $table->string('project_type', 60)->nullable();
            $table->string('business_name', 160)->nullable();
            $table->string('industry', 120)->nullable();
            $table->text('description')->nullable();
            $table->string('budget_range', 60)->nullable();
            $table->string('timeline', 60)->nullable();
            $table->string('recommended_service', 160)->nullable();
            $table->string('recommended_package', 160)->nullable();
            $table->string('complexity', 30)->nullable();
            $table->integer('lead_score')->nullable();
            $table->text('ai_summary')->nullable();
            $table->string('contact_name', 160)->nullable();
            $table->string('contact_email', 190)->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['session_id', 'status']);
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_sessions');
    }
};
