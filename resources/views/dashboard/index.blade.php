@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="welcome-section">
    <h1>Добро пожаловать, {{ auth()->user()->name }}!</h1>
    <p>Роль: {{ auth()->user()->role->name }}</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h4>Всего товаров</h4>
        <p class="stat-number">{{ $stats['total_products'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Складов</h4>
        <p class="stat-number">{{ $stats['total_warehouses'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Категорий</h4>
        <p class="stat-number">{{ $stats['total_categories'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Поставщиков</h4>
        <p class="stat-number">{{ $stats['total_suppliers'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Общий остаток</h4>
        <p class="stat-number stat-success">{{ $stats['total_stock'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Приходов</h4>
        <p class="stat-number stat-info">{{ $stats['total_incomes'] }}</p>
    </div>
    <div class="stat-card">
        <h4>Расходов</h4>
        <p class="stat-number stat-danger">{{ $stats['total_expenses'] }}</p>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Последние приходы</h3>
                <a href="/incomes" class="btn btn-sm btn-primary">Все приходы</a>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Склад</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentIncomes as $income)
                            <tr>
                                <td>{{ $income->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $income->warehouse->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">Нет приходов</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Последние расходы</h3>
                <a href="/expenses" class="btn btn-sm btn-primary">Все расходы</a>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Склад</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentExpenses as $expense)
                            <tr>
                                <td>{{ $expense->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $expense->warehouse->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">Нет расходов</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
