<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// ─── Public ────────────────────────────────────────────────────────────────
Route::get('/', [PortfolioController::class, 'index'])->name('home');
