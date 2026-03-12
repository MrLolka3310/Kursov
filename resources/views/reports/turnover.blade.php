@extends('layouts.app')

@section('title', 'Отчет по оборотам')

@section('page-title')
    <i class="fas fa-chart-bar"></i>
    Отчет по оборотам товаров
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
            <form method="GET" action="{{ route('reports.turnover') }}" class="form-row">
                <div class="form-group">
                    <label>Год</label>
                    <select name="year" class="form-control">
                        @for($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Месяц</label>
                    <select name="month" class="form-control">
                        <option value="1" {{ $month == 1 ? 'selected' : '' }}>Январь</option>
                        <option value="2" {{ $month == 2 ? 'selected' : '' }}>Февраль</option>
                        <option value="3" {{ $month == 3 ? 'selected' : '' }}>Март</option>
                        <option value="4" {{ $month == 4 ? 'selected' : '' }}>Апрель</option>
                        <option value="5" {{ $month == 5 ? 'selected' : '' }}>Май</option>
                        <option value="6" {{ $month == 6 ? 'selected' : '' }}>Июнь</option>
                        <option value="7" {{ $month == 7 ? 'selected' : '' }}>Июль</option>
                        <option value="8" {{ $month == 8 ? 'selected' : '' }}>Август</option>
                        <option value="9" {{ $month == 9 ? 'selected' : '' }}>Сентябрь</option>
                        <option value="10" {{ $month == 10 ? 'selected' : '' }}>Октябрь</option>
                        <option value="11" {{ $month == 11 ? 'selected' : '' }}>Ноябрь</option>
                        <option value="12" {{ $month == 12 ? 'selected' : '' }}>Декабрь</option>
                    </select>
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

    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Обороты за {{ $month }}.{{ $year }}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Категория</th>
                            <th>Приход</th>
                            <th>Расход</th>
                            <th>Остаток</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($turnover as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $product) }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->incoming_quantity, 3, ',', ' ') }} {{ $product->unit }}</td>
                                <td>{{ number_format($product->outgoing_quantity, 3, ',', ' ') }} {{ $product->unit }}</td>
                                <td>{{ number_format($product->current_stock, 3, ',', ' ') }} {{ $product->unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Нет данных за выбранный период</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection