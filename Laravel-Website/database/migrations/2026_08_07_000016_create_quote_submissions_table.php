<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_session_id')->unique();
            $table->string('reference', 40)->unique();
            $table->string('status', 30)->default('submitted');
            $table->string('contact_name', 160);
            $table->string('contact_email', 190);
            $table->string('contact_phone', 30)->nullable();
            $table->string('preferred_contact_method', 30)->nullable();
            $table->json('snapshot')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'submitted_at']);
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_submissions');
    }
};
