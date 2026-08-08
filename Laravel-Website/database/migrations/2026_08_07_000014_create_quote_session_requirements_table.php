<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_session_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_session_id');
            $table->unsignedBigInteger('quote_requirement_id');
            $table->string('source', 20)->default('user');
            $table->string('status', 20)->default('confirmed');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('quote_session_id');
            $table->unique(['quote_session_id', 'quote_requirement_id', 'source'], 'quote_session_req_unique');
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('cascade');
            $table->foreign('quote_requirement_id')->references('id')->on('quote_requirements')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_session_requirements');
    }
};
