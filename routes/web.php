<?php

use App\Http\Controllers\GeneratePublicLinkController;
use App\Http\Controllers\PublicTaskController;
use App\Http\Controllers\RevokePublicLinkController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('tasks/public/{token}', [PublicTaskController::class, 'show'])->name('tasks.public.show');

Route::middleware(['auth'])->group(function () {
    Route::resource('/tasks', TaskController::class)->except('show');
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::post('{task}/generate-link', GeneratePublicLinkController::class)->name('generate-link');
        Route::post('{task}/revoke-link', RevokePublicLinkController::class)->name('revoke-link');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
