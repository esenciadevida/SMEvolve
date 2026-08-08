<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('type', 30);
            $table->string('title', 200);
            $table->string('slug', 200)->nullable();
            $table->text('content');
            $table->string('status', 20)->default('draft');
            $table->string('priority', 20)->default('normal');
            $table->json('metadata')->nullable();
            $table->string('created_by', 120)->nullable();
            $table->string('updated_by', 120)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['type', 'status']);
            $table->index('slug');
            $table->index('status');
            $table->index('priority');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_items');
    }
};
