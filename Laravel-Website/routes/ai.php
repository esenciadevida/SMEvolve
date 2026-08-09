<?php

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
