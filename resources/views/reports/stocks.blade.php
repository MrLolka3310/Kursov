@extends('layouts.app')

@section('title', 'Отчёт по остаткам')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Отчёт по остаткам</h3>
        <a href="/dashboard" class="btn btn-secondary">Назад</a>
    </div>
    <div class="card-body">
        @if($stocks->isEmpty())
            <div class="alert alert-info">Нет данных об остатках</div>
        @else
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Склад</th>
                            <th>Товар</th>
                            <th>Категория</th>
                            <th>Количество</th>
                            <th>Единица</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $s)
                        <tr>
                            <td>{{ $s->warehouse->name }}</td>
                            <td>{{ $s->product->name }}</td>
                            <td>{{ $s->product->category->name ?? '-' }}</td>
                            <td>{{ $s->quantity }}</td>
                            <td>{{ $s->product->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
