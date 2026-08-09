<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_audit_logs', function (Blueprint $table) {
            $table->string('status', 30)->nullable()->after('new_value');
            $table->string('description', 500)->nullable()->after('status');
            $table->char('request_id', 36)->nullable()->after('description');
            $table->string('browser', 100)->nullable()->after('user_agent');
            $table->string('os', 100)->nullable()->after('browser');
            $table->string('device_type', 30)->nullable()->after('os');
            $table->string('location', 255)->nullable()->after('device_type');

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('admin_audit_logs', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropColumn(['status', 'description', 'request_id', 'browser', 'os', 'device_type', 'location']);
        });
    }
};
