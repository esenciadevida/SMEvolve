<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_consents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_session_id');
            $table->unsignedBigInteger('quote_submission_id')->nullable();
            $table->string('consent_type', 40);
            $table->string('document', 80);
            $table->string('document_version', 20);
            $table->boolean('accepted')->default(false);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->index('quote_session_id');
            $table->index('quote_submission_id');
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('cascade');
            $table->foreign('quote_submission_id')->references('id')->on('quote_submissions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_consents');
    }
};
