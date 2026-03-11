@extends('layouts.app')

@section('title', 'Товары')

@section('page-title')
    <i class="fas fa-box"></i>
    Товары
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список товаров
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новый товар
            </a>
        </div>
        <div class="card-body">
            <!-- Фильтры -->
            <div class="filter-box">
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Название или артикул">
                        </div>
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="form-control">
                                <option value="">Все категории</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i>
                                Поиск
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Таблица -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Артикул</th>
                            <th>Наименование</th>
                            <th>Категория</th>
                            <th>Цена закупки</th>
                            <th>Цена продажи</th>
                            <th>Остаток</th>
                            <th>Ед. изм.</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td><strong>{{ $product->sku }}</strong></td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->purchase_price, 2, ',', ' ') }} ₽</td>
                                <td>{{ number_format($product->selling_price, 2, ',', ' ') }} ₽</td>
                                <td>
                                    @php
                                        $stock = $product->current_stock;
                                        $stockClass = $stock <= $product->min_stock ? 'danger' : 'success';
                                    @endphp
                                    <span class="badge badge-{{ $stockClass }}">
                                        {{ number_format($stock, 3, ',', ' ') }}
                                    </span>
                                </td>
                                <td>{{ $product->unit }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Удалить">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;">Товары не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="pagination">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection