<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_session_id');
            $table->string('question_key', 80);
            $table->string('question', 255)->nullable();
            $table->text('answer');
            $table->string('answer_type', 30)->default('text');
            $table->string('source', 20)->default('user');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index('quote_session_id');
            $table->unique(['quote_session_id', 'question_key']);
            $table->foreign('quote_session_id')->references('id')->on('quote_sessions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_answers');
    }
};
