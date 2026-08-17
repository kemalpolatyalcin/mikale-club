<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
