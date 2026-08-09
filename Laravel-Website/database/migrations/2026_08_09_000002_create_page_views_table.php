<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_id', 64);
            $table->string('path', 500);
            $table->string('page_title', 255)->nullable();
            $table->string('referer_host', 190)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('os', 100)->nullable();
            $table->string('device_type', 30)->nullable();
            $table->string('locale', 10)->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->timestamp('viewed_at');

            $table->index(['viewed_at', 'path']);
            $table->index(['visitor_id', 'viewed_at']);
            $table->index(['device_type', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
