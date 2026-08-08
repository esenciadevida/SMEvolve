<?php

use App\Http\Controllers\Ai\Admin\AdminAuthController;
use App\Http\Controllers\Ai\Admin\AdminConfigController;
use App\Http\Controllers\Ai\Admin\AdminDashboardController;
use App\Http\Controllers\Ai\Admin\AdminKnowledgeController;
use App\Http\Controllers\Ai\Admin\AdminPromptController;
use App\Http\Controllers\Ai\Admin\AdminUsageController;
use App\Http\Controllers\Ai\AiApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1/ai')->name('ai.api.')->group(function () {
    Route::get('/status', [AiApiController::class, 'status'])->name('status');

    Route::post('/conversations', [AiApiController::class, 'storeConversation'])
        ->middleware('throttle:ai:conversations')
        ->name('conversations.store');

    Route::post('/conversations/{conversation:uuid}/messages', [AiApiController::class, 'sendMessage'])
        ->middleware('throttle:ai:messages')
        ->name('conversations.messages');

    Route::post('/quote-sessions', [AiApiController::class, 'storeQuoteSession'])
        ->middleware('throttle:ai:quote-sessions')
        ->name('quotes.store');

    Route::post('/quote-sessions/{quoteSession:uuid}/answers', [AiApiController::class, 'storeQuoteAnswer'])
        ->middleware('throttle:ai:quote-answers')
        ->name('quotes.answers');

    Route::post('/quote-sessions/{quoteSession:uuid}/analyze', [AiApiController::class, 'analyzeQuote'])
        ->middleware('throttle:ai:quotes')
        ->name('quotes.analyze');

    Route::post('/quote-sessions/{quoteSession:uuid}/submit', [AiApiController::class, 'submitQuote'])
        ->middleware('throttle:ai:quote-submit')
        ->name('quotes.submit');

    Route::post('/handoffs', [AiApiController::class, 'requestHandoff'])
        ->middleware('throttle:ai:handoffs')
        ->name('handoffs');
});

Route::prefix('admin/ai')->name('admin.ai.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:ai:admin-login')
        ->name('login.store');

    Route::middleware('ai.admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/config', [AdminConfigController::class, 'index'])->name('config');
        Route::post('/config', [AdminConfigController::class, 'update'])->name('config.update');

        Route::get('/prompts', [AdminPromptController::class, 'index'])->name('prompts');
        Route::post('/prompts/{prompt}/versions', [AdminPromptController::class, 'storeVersion'])->name('prompts.versions.store');
        Route::post('/prompts/{prompt}/versions/{version}/activate', [AdminPromptController::class, 'activateVersion'])->name('prompts.versions.activate');

        Route::get('/knowledge', [AdminKnowledgeController::class, 'index'])->name('knowledge.index');
        Route::post('/knowledge', [AdminKnowledgeController::class, 'store'])->name('knowledge.store');
        Route::delete('/knowledge/{knowledgeItem}', [AdminKnowledgeController::class, 'destroy'])->name('knowledge.destroy');

        Route::get('/usage', [AdminUsageController::class, 'index'])->name('usage');
        Route::get('/health', [AdminUsageController::class, 'health'])->name('health');
    });
});
