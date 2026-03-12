@extends('layouts.app')

@section('title', 'Дашборд')

@section('page-title')
    <i class="fas fa-tachometer-alt"></i>
    Панель управления
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <!-- Статистика в зависимости от роли -->
    <div class="stats-grid">
        @if($user->isAdmin())
            <div class="stat-card slide-in-right">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Всего товаров</h3>
                    <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info">
                    <h3>Приход сегодня</h3>
                    <div class="stat-number">{{ number_format($todayIncoming, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon warning">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Расход сегодня</h3>
                    <div class="stat-number">{{ number_format($todayOutgoing, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>Товары ниже min</h3>
                    <div class="stat-number">{{ number_format($lowStockProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon info">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info">
                    <h3>Поставщики</h3>
                    <div class="stat-number">{{ number_format($totalSuppliers, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Клиенты</h3>
                    <div class="stat-number">{{ number_format($totalCustomers, 0, ',', ' ') }}</div>
                </div>
            </div>
            
        @elseif($user->isManager())
            <div class="stat-card slide-in-right">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Всего товаров</h3>
                    <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Продажи сегодня</h3>
                    <div class="stat-number">{{ number_format($todayOutgoing, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>Продажи за месяц</h3>
                    <div class="stat-number">{{ number_format($monthlySales, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
        @elseif($user->isStorekeeper())
            <div class="stat-card slide-in-right">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Всего товаров</h3>
                    <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-info">
                    <h3>Приемка сегодня</h3>
                    <div class="stat-number">{{ number_format($todayIncoming, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon warning">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="stat-info">
                    <h3>Отгрузка сегодня</h3>
                    <div class="stat-number">{{ number_format($todayOutgoing, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>Товары ниже min</h3>
                    <div class="stat-number">{{ count($lowStockProducts) }}</div>
                </div>
            </div>
            
        @elseif($user->isAnalyst())
            <div class="stat-card slide-in-right">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Всего товаров</h3>
                    <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-ruble-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>Стоимость запасов</h3>
                    <div class="stat-number">{{ number_format($totalStockValue, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>Оборот за месяц</h3>
                    <div class="stat-number">{{ number_format($monthlyTurnover, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Средний чек</h3>
                    <div class="stat-number">{{ number_format($averageOrderValue, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
        @elseif($user->isAccountant())
            <div class="stat-card slide-in-right">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Всего товаров</h3>
                    <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon success">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <div class="stat-info">
                    <h3>Поступления за месяц</h3>
                    <div class="stat-number">{{ number_format($monthlyIncome, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon warning">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <div class="stat-info">
                    <h3>Реализация за месяц</h3>
                    <div class="stat-number">{{ number_format($monthlyExpense, 0, ',', ' ') }} ₽</div>
                </div>
            </div>
            
            <div class="stat-card slide-in-right">
                <div class="stat-icon info">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-info">
                    <h3>Черновики</h3>
                    <div class="stat-number">{{ $pendingInvoices }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Дополнительные блоки в зависимости от роли -->
    @if($user->isAdmin())
        <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <!-- Последние движения -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-history"></i>
                        Последние движения
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Товар</th>
                                    <th>Тип</th>
                                    <th>Кол-во</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                        <td>
                                            @switch($movement->type)
                                                @case('INCOMING')
                                                    <span class="badge badge-success">Приход</span>
                                                    @break
                                                @case('OUTGOING')
                                                    <span class="badge badge-danger">Расход</span>
                                                    @break
                                                @case('CORRECTION')
                                                    <span class="badge badge-warning">Коррекция</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ number_format($movement->quantity, 2, ',', ' ') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Нет движений</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Популярные товары -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-star"></i>
                        Топ-5 товаров по продажам
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Количество</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($item->total_quantity, 2, ',', ' ') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Нет данных</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif($user->isManager())
        <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <!-- Лучшие клиенты -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-crown"></i>
                        Лучшие клиенты
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Клиент</th>
                                    <th>Заказов</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $customer->orders_count }}</td>
                                        <td>{{ number_format($customer->total, 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center;">Нет данных</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Последние заказы -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-shopping-cart"></i>
                        Последние заказы
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Номер</th>
                                    <th>Клиент</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td>{{ $order->number }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                        <td>
                                            @switch($order->status)
                                                @case('draft')
                                                    <span class="badge badge-warning">Черновик</span>
                                                    @break
                                                @case('reserved')
                                                    <span class="badge badge-info">Резерв</span>
                                                    @break
                                                @case('shipped')
                                                    <span class="badge badge-success">Отгружен</span>
                                                    @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Нет заказов</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif($user->isStorekeeper())
        <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <!-- Товары ниже минимума -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-exclamation-triangle"></i>
                        Товары ниже минимального остатка
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Текущий остаток</th>
                                    <th>Минимум</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->current_stock, 2, ',', ' ') }}</td>
                                        <td>{{ number_format($product->min_stock, 2, ',', ' ') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center;">Нет товаров ниже минимума</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Последние движения -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-history"></i>
                        Последние движения
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Товар</th>
                                    <th>Тип</th>
                                    <th>Кол-во</th>
                                    <th>Ячейка</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $movement->product->name ?? 'N/A' }}</td>
                                        <td>
                                            @switch($movement->type)
                                                @case('INCOMING')
                                                    <span class="badge badge-success">Приход</span>
                                                    @break
                                                @case('OUTGOING')
                                                    <span class="badge badge-danger">Расход</span>
                                                    @break
                                                @case('CORRECTION')
                                                    <span class="badge badge-warning">Коррекция</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ number_format($movement->quantity, 2, ',', ' ') }}</td>
                                        <td>{{ $movement->warehouseCell->code ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Нет движений</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif($user->isAnalyst())
        <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <!-- Топ товаров -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-chart-line"></i>
                        Топ-10 товаров по продажам
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Продано</th>
                                    <th>Выручка</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($item->total_quantity, 2, ',', ' ') }}</td>
                                        <td>{{ number_format($item->total_quantity * ($item->product->selling_price ?? 0), 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center;">Нет данных</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    @elseif($user->isAccountant())
        <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
            <!-- Последние транзакции -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <i class="fas fa-exchange-alt"></i>
                        Последние транзакции
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Товар</th>
                                    <th>Тип</th>
                                    <th>Кол-во</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d.m.Y') }}</td>
                                        <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                                        <td>
                                            @switch($transaction->type)
                                                @case('INCOMING')
                                                    <span class="badge badge-success">Приход</span>
                                                    @break
                                                @case('OUTGOING')
                                                    <span class="badge badge-danger">Расход</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>{{ number_format($transaction->quantity, 2, ',', ' ') }}</td>
                                        <td>{{ number_format($transaction->quantity * ($transaction->product->purchase_price ?? 0), 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center;">Нет транзакций</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Быстрые действия (доступны всем, но разные) -->
    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <div>
                <i class="fas fa-bolt"></i>
                Быстрые действия
            </div>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @if($user->can('create', App\Models\Product::class))
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Новый товар
                    </a>
                @endif
                
                @if($user->can('create', App\Models\IncomingInvoice::class))
                    <a href="{{ route('incoming-invoices.create') }}" class="btn btn-success">
                        <i class="fas fa-truck"></i>
                        Приходная накладная
                    </a>
                @endif
                
                @if($user->can('create', App\Models\OutgoingOrder::class))
                    <a href="{{ route('outgoing-orders.create') }}" class="btn btn-warning">
                        <i class="fas fa-shopping-cart"></i>
                        Расходная накладная
                    </a>
                @endif
                
                @if($user->can('create', App\Models\Inventory::class))
                    <a href="{{ route('inventory.create') }}" class="btn btn-info">
                        <i class="fas fa-clipboard-list"></i>
                        Инвентаризация
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection