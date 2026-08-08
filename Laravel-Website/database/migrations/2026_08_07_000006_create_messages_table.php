<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('conversation_id');
            $table->string('role', 20);
            $table->text('content');
            $table->string('provider', 30)->nullable();
            $table->string('model', 120)->nullable();
            $table->integer('token_input')->default(0);
            $table->integer('token_output')->default(0);
            $table->integer('response_time_ms')->nullable();
            $table->string('status', 20)->default('stored');
            $table->string('request_id', 80)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index('conversation_id');
            $table->index(['conversation_id', 'created_at']);
            $table->index('role');
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
