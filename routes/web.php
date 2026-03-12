<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WarehouseCellController;
use App\Http\Controllers\IncomingInvoiceController;
use App\Http\Controllers\OutgoingOrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

// Публичные маршруты
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Защищенные маршруты (только авторизованные пользователи)
Route::middleware(['auth'])->group(function () {
    // Дашборд (доступен всем)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Товары
    Route::resource('products', ProductController::class);
    
    // Категории
    Route::resource('categories', CategoryController::class);
    
    // Поставщики
    Route::resource('suppliers', SupplierController::class);
    
    // Клиенты
    Route::resource('customers', CustomerController::class);
    
    // Ячейки склада
    Route::resource('warehouse-cells', WarehouseCellController::class);
    
    // Приходные накладные
    Route::resource('incoming-invoices', IncomingInvoiceController::class);
    
    // Расходные накладные
    Route::resource('outgoing-orders', OutgoingOrderController::class);
    
    // Инвентаризация
    Route::resource('inventory', InventoryController::class);
    
    // Отчеты
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('stock');
        Route::get('/movements', [ReportController::class, 'movementReport'])->name('movements');
        Route::get('/turnover', [ReportController::class, 'turnoverReport'])->name('turnover');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/financial', [ReportController::class, 'financialReport'])->name('financial');
    });
    
    // Управление пользователями
    Route::resource('users', UserController::class);
});