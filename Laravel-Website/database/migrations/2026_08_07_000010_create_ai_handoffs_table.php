<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_handoffs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->unsignedBigInteger('quote_session_id')->nullable();
            $table->string('reason', 40);
            $table->string('status', 20)->default('requested');
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('conversation_id');
            $table->index('quote_session_id');
            $table->index(['reason', 'status']);
            $table->index('status');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('set null');
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_handoffs');
    }
};
