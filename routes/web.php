<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\BotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/features', [PageController::class, 'features'])->name('features');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/demo', [PageController::class, 'demo'])->name('demo');
Route::get('/docs', [PageController::class, 'docs'])->name('docs');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Email verification (built-in)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth' , 'unverified'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Dashboard (must be verified)
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Billing
    Route::get('/dashboard/billing', [BillingController::class, 'plans'])->name('billing.plans');
    Route::post('/dashboard/billing/start/{code}', [BillingController::class, 'start'])->name('billing.start');
    Route::get('/dashboard/billing/invoice/{invoice}', [BillingController::class, 'invoiceShow'])->name('billing.invoice.show');
    Route::post('/dashboard/billing/invoice/{invoice}/proof', [BillingController::class, 'uploadProof'])->name('billing.invoice.proof');

    // Profile
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/dashboard/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // Bots (requires active plan)
    Route::middleware('active_plan')->group(function () {
        Route::get('/dashboard/bots', [BotController::class, 'index'])->name('bots.index');
        Route::get('/dashboard/bots/create', [BotController::class, 'create'])->name('bots.create');
        Route::post('/dashboard/bots', [BotController::class, 'store'])->name('bots.store');
        Route::get('/dashboard/bots/{bot}/edit', [BotController::class, 'edit'])->name('bots.edit');
        Route::post('/dashboard/bots/{bot}', [BotController::class, 'update'])->name('bots.update');
    });
});

// Admin
Route::middleware(['auth','verified','admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('admin.invoices');
    Route::post('/invoices/{invoice}/approve', [AdminController::class, 'approve'])->name('admin.invoices.approve');
    Route::post('/invoices/{invoice}/reject', [AdminController::class, 'reject'])->name('admin.invoices.reject');
    Route::get('/plans', [AdminController::class, 'plans'])->name('admin.plans');

    // Platform management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle_admin');
    Route::post('/users/{user}/toggle-suspend', [AdminController::class, 'toggleSuspend'])->name('admin.users.toggle_suspend');

    Route::get('/bots', [AdminController::class, 'bots'])->name('admin.bots');
    Route::post('/bots/{bot}/toggle-active', [AdminController::class, 'toggleBotActive'])->name('admin.bots.toggle_active');

    Route::get('/leads', [AdminController::class, 'leads'])->name('admin.leads');
    Route::get('/conversations', [AdminController::class, 'conversations'])->name('admin.conversations');
});
