<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminAdministratorController;
use App\Http\Controllers\Admin\AdminAiController;
use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminAuditController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminChatbotController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPortfolioCategoryController;
use App\Http\Controllers\Admin\AdminPortfolioController;
use App\Http\Controllers\Admin\AdminQuoteController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminSearchController;
use App\Http\Controllers\Admin\AdminSettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:admin:login')
        ->name('login.store');

    Route::middleware(['admin.auth'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->middleware('admin.permission:dashboard.view')
            ->name('dashboard');

        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])
            ->middleware('admin.permission:dashboard.view')
            ->name('analytics');

        Route::get('/search', [AdminSearchController::class, 'index'])
            ->middleware('admin.permission:quotes.search,administrators.view,settings.view,ai.view,audit.view,portfolio.view')
            ->name('search');

        Route::get('/search/autocomplete', [AdminSearchController::class, 'autocomplete'])
            ->middleware([
                'admin.permission:quotes.search,administrators.view,settings.view,ai.view,audit.view,portfolio.view',
                'throttle:admin:search',
            ])
            ->name('search.autocomplete');

        Route::prefix('website')->name('settings.')->group(function () {
            Route::get('/{group}', [AdminSettingsController::class, 'index'])
                ->middleware('admin.permission:settings.view')
                ->whereIn('group', ['general', 'contact', 'business', 'social'])
                ->name('index');
            Route::post('/{group}', [AdminSettingsController::class, 'update'])
                ->middleware('admin.permission:settings.update')
                ->whereIn('group', ['general', 'contact', 'business', 'social'])
                ->name('update');
        });

        Route::prefix('quotes')->name('quotes.')->group(function () {
            Route::get('/', [AdminQuoteController::class, 'index'])
                ->middleware('admin.permission:quotes.view')
                ->name('index');
            Route::get('/{quote}', [AdminQuoteController::class, 'show'])
                ->middleware('admin.permission:quotes.view')
                ->name('show');
            Route::post('/{quote}/status', [AdminQuoteController::class, 'updateStatus'])
                ->middleware('admin.permission:quotes.update_status')
                ->name('status');
        });

        Route::get('/chatbot', [AdminChatbotController::class, 'index'])
            ->middleware('admin.permission:chatbot.view')
            ->name('chatbot.index');
        Route::post('/chatbot', [AdminChatbotController::class, 'update'])
            ->middleware('admin.permission:chatbot.update')
            ->name('chatbot.update');

        Route::prefix('ai')->name('ai.')->group(function () {
            Route::get('/settings', [AdminAiController::class, 'settings'])
                ->middleware('admin.permission:ai.view')
                ->name('settings');
            Route::post('/settings', [AdminAiController::class, 'update'])
                ->middleware('admin.permission:ai.update')
                ->name('update');
            Route::get('/status', [AdminAiController::class, 'status'])
                ->middleware('admin.permission:ai.view')
                ->name('status');
        });

        Route::prefix('administrators')->name('administrators.')->group(function () {
            Route::get('/', [AdminAdministratorController::class, 'index'])
                ->middleware('admin.permission:administrators.view')
                ->name('index');
            Route::get('/create', [AdminAdministratorController::class, 'create'])
                ->middleware('admin.permission:administrators.create')
                ->name('create');
            Route::post('/', [AdminAdministratorController::class, 'store'])
                ->middleware('admin.permission:administrators.create')
                ->name('store');
            Route::get('/{administrator}', [AdminAdministratorController::class, 'show'])
                ->middleware('admin.permission:administrators.view')
                ->name('show');
            Route::get('/{administrator}/edit', [AdminAdministratorController::class, 'edit'])
                ->middleware('admin.permission:administrators.update')
                ->name('edit');
            Route::put('/{administrator}', [AdminAdministratorController::class, 'update'])
                ->middleware('admin.permission:administrators.update')
                ->name('update');
            Route::post('/{administrator}/disable', [AdminAdministratorController::class, 'disable'])
                ->middleware('admin.permission:administrators.disable')
                ->name('disable');
            Route::post('/{administrator}/enable', [AdminAdministratorController::class, 'enable'])
                ->middleware('admin.permission:administrators.disable')
                ->name('enable');
        });

        Route::prefix('roles')->name('roles.')->group(function () {
            Route::get('/', [AdminRoleController::class, 'index'])
                ->middleware('admin.permission:administrators.view')
                ->name('index');
            Route::get('/create', [AdminRoleController::class, 'create'])
                ->middleware('admin.permission:administrators.update')
                ->name('create');
            Route::post('/', [AdminRoleController::class, 'store'])
                ->middleware('admin.permission:administrators.update')
                ->name('store');
            Route::get('/{role}/edit', [AdminRoleController::class, 'edit'])
                ->middleware('admin.permission:administrators.update')
                ->name('edit');
            Route::put('/{role}', [AdminRoleController::class, 'update'])
                ->middleware('admin.permission:administrators.update')
                ->name('update');
            Route::delete('/{role}', [AdminRoleController::class, 'destroy'])
                ->middleware('admin.permission:administrators.update')
                ->name('destroy');
        });

        Route::prefix('portfolio')->name('portfolio.')->group(function () {
            Route::get('/', [AdminPortfolioController::class, 'index'])
                ->middleware('admin.permission:portfolio.view')
                ->name('index');
            Route::get('/create', [AdminPortfolioController::class, 'create'])
                ->middleware('admin.permission:portfolio.create')
                ->name('create');
            Route::post('/', [AdminPortfolioController::class, 'store'])
                ->middleware('admin.permission:portfolio.create')
                ->name('store');
            Route::get('/{portfolio_project}/edit', [AdminPortfolioController::class, 'edit'])
                ->middleware('admin.permission:portfolio.update')
                ->name('edit');
            Route::put('/{portfolio_project}', [AdminPortfolioController::class, 'update'])
                ->middleware('admin.permission:portfolio.update')
                ->name('update');
            Route::delete('/{portfolio_project}', [AdminPortfolioController::class, 'destroy'])
                ->middleware('admin.permission:portfolio.delete')
                ->name('destroy');
            Route::post('/{portfolio_project}/publish', [AdminPortfolioController::class, 'togglePublish'])
                ->middleware('admin.permission:portfolio.publish')
                ->name('publish');

            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/', [AdminPortfolioCategoryController::class, 'index'])
                    ->middleware('admin.permission:portfolio.view')
                    ->name('index');
                Route::get('/create', [AdminPortfolioCategoryController::class, 'create'])
                    ->middleware('admin.permission:portfolio.create')
                    ->name('create');
                Route::post('/', [AdminPortfolioCategoryController::class, 'store'])
                    ->middleware('admin.permission:portfolio.create')
                    ->name('store');
                Route::get('/{portfolio_category}/edit', [AdminPortfolioCategoryController::class, 'edit'])
                    ->middleware('admin.permission:portfolio.update')
                    ->name('edit');
                Route::put('/{portfolio_category}', [AdminPortfolioCategoryController::class, 'update'])
                    ->middleware('admin.permission:portfolio.update')
                    ->name('update');
                Route::delete('/{portfolio_category}', [AdminPortfolioCategoryController::class, 'destroy'])
                    ->middleware('admin.permission:portfolio.delete')
                    ->name('destroy');
            });
        });

        Route::get('/audit', [AdminAuditController::class, 'index'])
            ->middleware('admin.permission:audit.view')
            ->name('audit.index');

        Route::prefix('account')->name('profile.')->group(function () {
            Route::get('/profile', [AdminAccountController::class, 'profile'])->name('index');
            Route::post('/profile', [AdminAccountController::class, 'updateProfile'])
                ->middleware('admin.permission:profile.update')
                ->name('update');
        });

        Route::prefix('account')->name('security.')->group(function () {
            Route::get('/security', [AdminAccountController::class, 'security'])->name('index');
            Route::post('/security/password', [AdminAccountController::class, 'updatePassword'])
                ->middleware('admin.permission:security.password_update')
                ->name('password');
        });
    });
});
