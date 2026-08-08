<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('slug', 150)->nullable();
            $table->string('title', 190)->nullable();
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();
            $table->json('data')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();

            $table->unique(['type', 'slug']);
            $table->index(['type', 'is_published']);
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
