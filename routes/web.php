<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReceptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/reception', [ReceptionController::class, 'index'])->name('reception.index');
Route::post('/reception/check-in', [ReceptionController::class, 'store'])->name('reception.checkin');
Route::post('/reception/check-out/{guest}', [ReceptionController::class, 'checkout'])->name('reception.checkout');
