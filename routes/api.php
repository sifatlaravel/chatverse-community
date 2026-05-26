<?php

use App\Http\Controllers\Api\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/widget/config/{key}', [WidgetController::class, 'config'])->name('api.widget.config');
Route::post('/widget/message', [WidgetController::class, 'message'])->name('api.widget.message');
Route::post('/widget/lead', [WidgetController::class, 'lead'])->name('api.widget.lead');
