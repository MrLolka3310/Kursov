@extends('layouts.app')

@section('title', 'Отчет по продажам')

@section('page-title')
    <i class="fas fa-chart-line"></i>
    Отчет по продажам
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-filter"></i>
                Фильтр отчета
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.sales') }}" class="form-row">
                <div class="form-group">
                    <label>Начальная дата</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate instanceof \Carbon\Carbon ? $startDate->format('Y-m-d') : $startDate }}">
                </div>
                <div class="form-group">
                    <label>Конечная дата</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate instanceof \Carbon\Carbon ? $endDate->format('Y-m-d') : $endDate }}">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                        Применить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>Количество продаж</h3>
                <div class="stat-number">{{ $ordersCount }}</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-ruble-sign"></i>
            </div>
            <div class="stat-info">
                <h3>Общая сумма</h3>
                <div class="stat-number">{{ number_format($totalSales, 2, ',', ' ') }} ₽</div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>Средний чек</h3>
                <div class="stat-number">{{ $ordersCount > 0 ? number_format($totalSales / $ordersCount, 2, ',', ' ') : 0 }} ₽</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Детализация продаж
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Номер заказа</th>
                            <th>Дата</th>
                            <th>Клиент</th>
                            <th>Количество товаров</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $order)
                            <tr>
                                <td><a href="{{ route('outgoing-orders.show', $order) }}">{{ $order->number }}</a></td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                <td>{{ $order->items->sum('quantity') }}</td>
                                <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                <td>
                                    @switch($order->status)
                                        @case('shipped')
                                            <span class="badge badge-success">Отгружен</span>
                                            @break
                                        @case('reserved')
                                            <span class="badge badge-info">Резерв</span>
                                            @break
                                        @case('draft')
                                            <span class="badge badge-warning">Черновик</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Нет данных за выбранный период</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection