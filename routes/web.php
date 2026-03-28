<?php
use Illuminate\Support\Facades\Route;
use Ekramul\SecurityGuard\Http\Controllers\DashboardController;

Route::middleware(['web','auth'])->group(function() {
    Route::get('security/dashboard', [DashboardController::class,'index'])->name('security.dashboard');
});
