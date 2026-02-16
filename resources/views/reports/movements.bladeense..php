@extends('layouts.app')

@section('title', 'Движение товаров')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Движение товаров</h3>
        <a href="/dashboard" class="btn btn-secondary">Назад</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <h4>Приход</h4>
                @if($incomes->isEmpty())
                    <div class="alert alert-info">Нет данных о приходе</div>
                @else
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Склад</th>
                                    <th>Поставщик</th>
                                    <th>Товаров</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes as $i)
                                <tr>
                                    <td>{{ $i->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $i->warehouse->name }}</td>
                                    <td>{{ $i->supplier->name ?? '-' }}</td>
                                    <td>{{ $i->items->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="col-12 col-md-6">
                <h4>Расход</h4>
                @if($expenses->isEmpty())
                    <div class="alert alert-info">Нет данных о расходе</div>
                @else
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Склад</th>
                                    <th>Товаров</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $e)
                                <tr>
                                    <td>{{ $e->created_at->format('d.m.Y H:i') }}</td>
                                    <td>{{ $e->warehouse->name }}</td>
                                    <td>{{ $e->items->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
