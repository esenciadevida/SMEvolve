<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_usage', function (Blueprint $table) {
            $table->id();
            $table->string('request_id', 80)->index();
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->string('endpoint', 120)->nullable();
            $table->string('provider', 30)->nullable();
            $table->string('model', 120)->nullable();
            $table->integer('input_tokens')->default(0);
            $table->integer('output_tokens')->default(0);
            $table->integer('total_tokens')->default(0);
            $table->integer('response_time_ms')->nullable();
            $table->string('status', 20)->default('success');
            $table->string('error_type', 40)->nullable();
            $table->timestamps();

            $table->index('conversation_id');
            $table->index('message_id');
            $table->index(['created_at', 'status']);
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('set null');
            $table->foreign('message_id')->references('id')->on('messages')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_usage');
    }
};
