<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StockController;

use App\Http\Controllers\SupplierController;

use App\Http\Controllers\IncomeController;

use App\Http\Controllers\ExpenseController;


Route::get('/', fn () => redirect('/login'));

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth');


Route::middleware(['auth'])->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('products', ProductController::class)->except(['show']);
    });

    Route::middleware('role:admin,manager,storekeeper')->group(function () {
        Route::get('/products-list', [ProductController::class, 'list'])
            ->name('products.list');
    });

});

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::resource('warehouses', WarehouseController::class);
    });

    Route::middleware('role:admin,manager,storekeeper')->group(function () {
        Route::get('/stocks', [StockController::class, 'index']);
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('suppliers', SupplierController::class);
});

Route::middleware(['auth', 'role:admin,storekeeper'])->group(function () {
    Route::resource('incomes', IncomeController::class)->except(['edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'role:admin,storekeeper'])->group(function () {
    Route::resource('expenses', ExpenseController::class)
        ->except(['edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'role:admin,manager'])->get(
    '/reports/stocks',
    [\App\Http\Controllers\ReportController::class, 'stocks']
);

Route::middleware(['auth', 'role:admin,manager'])->get(
    '/reports/movements',
    [\App\Http\Controllers\ReportController::class, 'movements']
);
