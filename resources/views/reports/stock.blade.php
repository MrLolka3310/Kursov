@extends('layouts.app')

@section('title', 'Отчет по остаткам')

@section('page-title')
    <i class="fas fa-chart-bar"></i>
    Отчет по остаткам
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-boxes"></i>
                Остатки товаров на складе
            </div>
        </div>
        <div class="card-body">
            <div class="filter-box">
                <form method="GET" action="{{ route('reports.stock') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="form-control">
                                <option value="">Все категории</option>
                                @foreach(App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i>
                                Применить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div style="margin-bottom: 20px; text-align: right;">
                <strong>Общая стоимость запасов:</strong>
                <h2>{{ number_format($totalValue, 2, ',', ' ') }} ₽</h2>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Артикул</th>
                            <th>Наименование</th>
                            <th>Категория</th>
                            <th>Остаток</th>
                            <th>Закупочная цена</th>
                            <th>Стоимость запасов</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            @php
                                $stock = $product->current_stock;
                                $stockValue = $stock * $product->purchase_price;
                                $status = $stock <= $product->min_stock ? 'danger' : ($stock >= $product->max_stock ? 'warning' : 'success');
                                $statusText = $stock <= $product->min_stock ? 'Ниже минимума' : ($stock >= $product->max_stock ? 'Выше максимума' : 'Норма');
                            @endphp
                            <tr>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($stock, 3, ',', ' ') }} {{ $product->unit }}</td>
                                <td>{{ number_format($product->purchase_price, 2, ',', ' ') }} ₽</td>
                                <td>{{ number_format($stockValue, 2, ',', ' ') }} ₽</td>
                                <td>
                                    <span class="badge badge-{{ $status }}">{{ $statusText }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection