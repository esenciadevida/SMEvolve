<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quote_sessions', function (Blueprint $table) {
            $table->timestamp('last_activity_at')->nullable()->after('started_at');
            $table->timestamp('expires_at')->nullable()->after('last_activity_at');

            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('quote_sessions', function (Blueprint $table) {
            $table->dropIndex(['expires_at']);
            $table->dropColumn(['last_activity_at', 'expires_at']);
        });
    }
};
