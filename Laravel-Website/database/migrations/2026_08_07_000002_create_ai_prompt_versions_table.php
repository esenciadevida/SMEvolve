<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_prompt_versions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prompt_id');
            $table->string('version', 20);
            $table->text('content');
            $table->string('status', 20)->default('draft');
            $table->string('created_by', 120)->nullable();
            $table->string('activated_by', 120)->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
            $table->unique(['prompt_id', 'version']);
            $table->foreign('prompt_id')->references('id')->on('ai_prompts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_prompt_versions');
    }
};
