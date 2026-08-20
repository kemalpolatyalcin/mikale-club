<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReceptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/table/{token}', [OrderController::class, 'showTable'])->name('table.show');
Route::get('/api/menu/{tableNumber}', [OrderController::class, 'getTableMenuApi'])->name('api.table.menu');

Route::post('/table/join', [OrderController::class, 'joinTable'])->name('table.join');
Route::post('/table/leave', [OrderController::class, 'leaveTable'])->name('table.leave');
Route::post('/orders/submit', [OrderController::class, 'storeOrder'])->name('orders.submit');
Route::get('/api/table/{tableNumber}/orders', [OrderController::class, 'getTableOrders'])->name('table.orders');

Route::get('/reception/login', [ReceptionController::class, 'showLogin'])->name('reception.login');
Route::post('/reception/login', [ReceptionController::class, 'login'])->name('reception.login.submit');
Route::post('/reception/logout', [ReceptionController::class, 'logout'])->name('reception.logout');

Route::get('/portal', [ReceptionController::class, 'index'])->name('portal.index');
Route::get('/reception', [ReceptionController::class, 'index'])->name('reception.index');
Route::post('/reception/check-in', [ReceptionController::class, 'store'])->name('reception.checkin');
Route::post('/reception/guests/{guest}/update', [ReceptionController::class, 'updateGuest'])->name('reception.guest.update');
Route::delete('/reception/guests/{guest}', [ReceptionController::class, 'deleteGuest'])->name('reception.guest.delete');
Route::post('/reception/check-out/{guest}', [ReceptionController::class, 'checkout'])->name('reception.checkout');

Route::post('/reception/categories', [ReceptionController::class, 'storeCategory'])->name('reception.category.store');
Route::post('/reception/categories/{category}/update', [ReceptionController::class, 'updateCategory'])->name('reception.category.update');
Route::post('/reception/categories/{category}/toggle', [ReceptionController::class, 'toggleCategory'])->name('reception.category.toggle');
Route::post('/reception/categories/{category}/reorder', [ReceptionController::class, 'reorderCategory'])->name('reception.category.reorder');
Route::delete('/reception/categories/{category}', [ReceptionController::class, 'deleteCategory'])->name('reception.category.delete');

Route::post('/reception/products', [ReceptionController::class, 'storeProduct'])->name('reception.product.store');
Route::post('/reception/products/{product}/update', [ReceptionController::class, 'updateProduct'])->name('reception.product.update');
Route::post('/reception/products/{product}/toggle', [ReceptionController::class, 'toggleProduct'])->name('reception.product.toggle');
Route::post('/reception/products/{product}/reorder', [ReceptionController::class, 'reorderProduct'])->name('reception.product.reorder');
Route::delete('/reception/products/{product}', [ReceptionController::class, 'deleteProduct'])->name('reception.product.delete');

Route::post('/reception/tables', [ReceptionController::class, 'storeTable'])->name('reception.table.store');
Route::post('/reception/tables/{table}/update', [ReceptionController::class, 'updateTable'])->name('reception.table.update');
Route::post('/reception/tables/{table}/toggle', [ReceptionController::class, 'toggleTable'])->name('reception.table.toggle');
Route::delete('/reception/tables/{table}', [ReceptionController::class, 'deleteTable'])->name('reception.table.delete');
Route::post('/reception/tables/{table}/regenerate-qr', [ReceptionController::class, 'regenerateTableQr'])->name('reception.table.regenerate_qr');
Route::get('/reception/tables/{table}/print-qr', [ReceptionController::class, 'printTableQr'])->name('reception.table.print_qr');
Route::get('/reception/tables/print-all-qr', [ReceptionController::class, 'printAllTablesQr'])->name('reception.tables.print_all');

Route::post('/reception/orders/{order}/status', [ReceptionController::class, 'updateOrderStatus'])->name('reception.order.status');
Route::delete('/reception/orders/{order}', [ReceptionController::class, 'deleteOrder'])->name('reception.order.delete');
