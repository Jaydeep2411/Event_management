<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;

Route::get('/login_view', [AdminController::class, 'index'])->name('login_view');
Route::post('/login', [AdminController::class, 'login'])->name('admin_login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [EventController::class, 'index'])->name('event');
    Route::get('/add_event', [EventController::class, 'create'])->name('add_event');
    Route::post('/event_store', [EventController::class, 'store'])->name('events.store');
    Route::post('/event/update-status', [EventController::class, 'updateStatus'])->name('event.updateStatus');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});
