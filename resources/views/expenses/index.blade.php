@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Расходы</h3>
        <a href="/expenses/create" class="btn btn-primary">Новый расход</a>
    </div>
    <div class="card-body">
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Склад</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $e)
                    <tr>
                        <td>{{ $e->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $e->warehouse->name }}</td>
                        <td>
                            <a href="/expenses/{{ $e->id }}" class="btn btn-sm btn-info">Просмотр</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Нет расходов</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
