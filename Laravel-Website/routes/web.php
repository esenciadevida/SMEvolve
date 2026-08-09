<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/ai.php';
require __DIR__.'/admin.php';

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServicesController::class, 'show'])->name('services.show');

Route::get('/packages', [PackageController::class, 'index'])->name('packages');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
Route::get('/portfolio/category/{category}', [PortfolioController::class, 'category'])->name('portfolio.category');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])
    ->middleware('throttle:public-search')
    ->name('search.autocomplete');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:contact');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/robots.txt', function () {
    return response(file_get_contents(public_path('robots.txt')), 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->name('robots');

Route::prefix('quote')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('quote');
    Route::post('/start', [QuoteController::class, 'start'])
        ->middleware('throttle:quote:steps')
        ->name('quote.start');
    Route::get('/confirmation/{reference}', [QuoteController::class, 'confirmation'])->name('quote.confirmation');

    Route::get('/{quoteSession:uuid}/review', [QuoteController::class, 'review'])->name('quote.review');
    Route::post('/{quoteSession:uuid}/submit', [QuoteController::class, 'submit'])
        ->middleware('throttle:quote:submit')
        ->name('quote.submit');

    Route::post('/{quoteSession:uuid}/ai/suggest-features', [QuoteController::class, 'suggestFeatures'])
        ->middleware('throttle:quote:ai')
        ->name('quote.ai.suggest-features');
    Route::post('/{quoteSession:uuid}/ai/improve-description', [QuoteController::class, 'improveDescription'])
        ->middleware('throttle:quote:ai')
        ->name('quote.ai.improve-description');

    Route::get('/{quoteSession:uuid}', [QuoteController::class, 'show'])
        ->whereUuid('quoteSession')
        ->name('quote.show');
    Route::post('/{quoteSession:uuid}/{stepKey}', [QuoteController::class, 'storeStep'])
        ->whereUuid('quoteSession')
        ->middleware('throttle:quote:steps')
        ->name('quote.step.store');
});

Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy-policy.index');
Route::get('/terms', [LegalController::class, 'terms'])->name('terms.index');
Route::get('/cookies', [LegalController::class, 'cookies'])->name('cookies.index');

Route::fallback(function () {
    abort(404);
});
