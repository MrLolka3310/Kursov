@extends('layouts.app')

@section('title', 'Создание расхода')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Списание товара</h3>
        <a href="/expenses" class="btn btn-secondary">Назад к списку</a>
    </div>
    <div class="card-body">
        <form method="POST" action="/expenses" id="expenseForm">
            @csrf

            <div class="form-group">
                <label for="warehouse_id">Выберите склад <span class="text-danger">*</span></label>
                <select name="warehouse_id" id="warehouse_id" class="form-control" required onchange="this.form.submit()">
                    <option value="">-- Выберите склад --</option>
                    @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                        {{ $w->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            @if(request('warehouse_id'))
            <h4>Товары на складе</h4>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Название товара</th>
                            <th>Категория</th>
                            <th>Доступно</th>
                            <th>Единица</th>
                            <th>Количество для списания</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        @php $available = $stocks[$p->id] ?? 0; @endphp
                        @if($available > 0)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name ?? '-' }}</td>
                            <td><span class="badge {{ $available > 10 ? 'badge-success' : 'badge-warning' }}">{{ $available }}</span></td>
                            <td>{{ $p->unit }}</td>
                            <td>
                                <input type="number"
                                    name="products[{{ $p->id }}]"
                                    value="0"
                                    min="0"
                                    max="{{ $available }}"
                                    class="form-control"
                                    placeholder="0">
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

<<<<<<< Updated upstream
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-danger">Списать товар</button>
                <a href="/expenses" class="btn btn-secondary">Отмена</a>
            </div>
            @else
            <div class="alert alert-info">
                Пожалуйста, выберите склад для отображения доступных товаров.
            </div>
            @endif
        </form>
    </div>
=======
<h4>Товары</h4>

@foreach($products as $p)
<div>
    {{ $p->name }}
    <input type="number"
        name="products[{{ $p->id }}]"
        value="0"
        min="0">
>>>>>>> Stashed changes
</div>
@endsection
