<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_category_id')->nullable()->constrained('portfolio_categories')->nullOnDelete();
            $table->string('slug', 150)->unique();
            $table->string('title', 150);
            $table->string('status', 60)->default('Active Project');
            $table->boolean('featured')->default(false);
            $table->string('image', 500)->nullable();
            $table->string('industry', 100)->nullable();
            $table->string('project_type', 100)->nullable();
            $table->string('summary', 1000)->nullable();
            $table->string('short_description', 500);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->json('services')->nullable();
            $table->json('services_slugs')->nullable();
            $table->json('technologies')->nullable();
            $table->json('gallery')->nullable();
            $table->json('challenge')->nullable();
            $table->json('solution')->nullable();
            $table->json('features')->nullable();
            $table->json('outcome')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['is_published', 'featured']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
