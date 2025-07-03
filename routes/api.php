<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;


Route::get('/event_data', [EventController::class, 'event_data'])->name('event_data');
