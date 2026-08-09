<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_audit_logs', function (Blueprint $table) {
            $table->string('browser', 100)->nullable()->after('user_agent');
            $table->string('os', 100)->nullable()->after('browser');
            $table->string('device_type', 30)->nullable()->after('os');
        });
    }

    public function down(): void
    {
        Schema::table('ai_audit_logs', function (Blueprint $table) {
            $table->dropColumn(['browser', 'os', 'device_type']);
        });
    }
};
