<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DesignWorkController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// ─── Public ────────────────────────────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'contact'])
    ->name('contact')
    ->middleware('throttle:5,1'); // 5 req/min anti-spam

// ─── Admin Auth ────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])
            ->name('login.post')
            ->middleware('throttle:10,1');
    });

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ─── Protected Admin Routes ────────────────────────────────────────────
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('skills', SkillController::class)->except(['show']);
        Route::resource('design-works', DesignWorkController::class)->except(['show']);

        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::get('{message}', [MessageController::class, 'show'])->name('show');
            Route::patch('{message}/toggle-read', [MessageController::class, 'toggleRead'])->name('toggle-read');
            Route::delete('{message}', [MessageController::class, 'destroy'])->name('destroy');
        });
    });
});
