@extends('layouts.app')

@section('title', 'Отчет по движениям')

@section('page-title')
    <i class="fas fa-exchange-alt"></i>
    Отчет по движениям товаров
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
            <form method="GET" action="{{ route('reports.movements') }}" class="form-row">
                <div class="form-group">
                    <label>Начальная дата</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="form-group">
                    <label>Конечная дата</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
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
                Движения товаров
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Товар</th>
                            <th>Тип</th>
                            <th>Количество</th>
                            <th>Ячейка</th>
                            <th>Документ</th>
                            <th>Пользователь</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('products.show', $movement->product) }}">
                                        {{ $movement->product->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td>
                                    @switch($movement->type)
                                        @case('INCOMING')
                                            <span class="badge badge-success">Приход</span>
                                            @break
                                        @case('OUTGOING')
                                            <span class="badge badge-danger">Расход</span>
                                            @break
                                        @case('CORRECTION')
                                            <span class="badge badge-warning">Коррекция</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ number_format($movement->quantity, 3, ',', ' ') }}</td>
                                <td>{{ $movement->warehouseCell->code ?? 'N/A' }}</td>
                                <td>
                                    @if($movement->document_type == 'incoming_invoice')
                                        <a href="{{ route('incoming-invoices.show', $movement->document_id) }}">Накладная #{{ $movement->document_id }}</a>
                                    @elseif($movement->document_type == 'outgoing_order')
                                        <a href="{{ route('outgoing-orders.show', $movement->document_id) }}">Заказ #{{ $movement->document_id }}</a>
                                    @else
                                        {{ $movement->document_type }} #{{ $movement->document_id }}
                                    @endif
                                </td>
                                <td>{{ $movement->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">Нет движений за выбранный период</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $movements->links() }}
            </div>
        </div>
    </div>
@endsection