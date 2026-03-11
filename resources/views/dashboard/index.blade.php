@extends('layouts.app')

@section('title', 'Дашборд')

@section('page-title')
    <i class="fas fa-tachometer-alt"></i>
    Панель управления
@endsection

@section('content')
    <!-- Статистика -->
    <div class="stats-grid">
        <div class="stat-card slide-in-right">
            <div class="stat-icon primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>Всего товаров</h3>
                <div class="stat-number">{{ number_format($totalProducts, 0, ',', ' ') }}</div>
            </div>
        </div>
        
        <div class="stat-card slide-in-right" style="animation-delay: 0.1s">
            <div class="stat-icon success">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-info">
                <h3>Приход сегодня</h3>
                <div class="stat-number">{{ number_format($todayIncoming, 0, ',', ' ') }}</div>
            </div>
        </div>
        
        <div class="stat-card slide-in-right" style="animation-delay: 0.2s">
            <div class="stat-icon warning">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>Расход сегодня</h3>
                <div class="stat-number">{{ number_format($todayOutgoing, 0, ',', ' ') }}</div>
            </div>
        </div>
        
        <div class="stat-card slide-in-right" style="animation-delay: 0.3s">
            <div class="stat-icon danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>Товары ниже min</h3>
                <div class="stat-number">{{ number_format($lowStockProducts, 0, ',', ' ') }}</div>
            </div>
        </div>
    </div>

    <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
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
                                <th>Пользователь</th>
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
                                    <td>{{ $movement->user->name ?? 'N/A' }}</td>
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
                                <th>Доля</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($item->total_quantity, 2, ',', ' ') }}</td>
                                    <td>
                                        <div style="background: #f0f0f0; height: 20px; border-radius: 10px; overflow: hidden;">
                                            <div style="background: var(--secondary-color); height: 100%; width: {{ min(100, ($item->total_quantity / $topProducts->sum('total_quantity') * 100)) }}%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center;">Нет данных о продажах</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Быстрые действия -->
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-bolt"></i>
                Быстрые действия
            </div>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Новый товар
                </a>
                <a href="{{ route('incoming-invoices.create') }}" class="btn btn-success">
                    <i class="fas fa-truck"></i>
                    Приходная накладная
                </a>
                <a href="{{ route('outgoing-orders.create') }}" class="btn btn-warning">
                    <i class="fas fa-shopping-cart"></i>
                    Расходная накладная
                </a>
                <a href="{{ route('inventory.create') }}" class="btn btn-info">
                    <i class="fas fa-clipboard-list"></i>
                    Инвентаризация
                </a>
            </div>
        </div>
    </div>
@endsection