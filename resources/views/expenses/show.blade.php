@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Детали расхода</h3>
        <a href="/expenses" class="btn btn-secondary">Назад к списку</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <p><strong>Дата:</strong> {{ $expense->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Склад:</strong> {{ $expense->warehouse->name }}</p>
                <p><strong>Пользователь:</strong> {{ $expense->user->name }}</p>
            </div>
        </div>

        <h4>Товары</h4>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Название товара</th>
                        <th>Количество</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expense->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">Нет товаров</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
