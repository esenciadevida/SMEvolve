<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('administrator_id')->constrained('administrators')->cascadeOnDelete();
            $table->string('event', 100);
            $table->string('channel', 30)->default('email');
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['administrator_id', 'event', 'channel'], 'admin_notif_prefs_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notification_preferences');
    }
};
