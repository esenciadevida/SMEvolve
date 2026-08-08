<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_ai_interactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_session_id');
            $table->string('operation', 60);
            $table->string('provider', 40)->nullable();
            $table->string('model', 120)->nullable();
            $table->string('prompt_version', 120)->nullable();
            $table->string('status', 30)->default('completed');
            $table->string('input_hash', 64)->nullable();
            $table->integer('input_tokens')->nullable();
            $table->integer('output_tokens')->nullable();
            $table->integer('duration_ms')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['quote_session_id', 'operation']);
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_ai_interactions');
    }
};
