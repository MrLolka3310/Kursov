@extends('layouts.app')

@section('title', 'Расходные накладные')

@section('page-title')
    <i class="fas fa-shopping-cart"></i>
    Расходные накладные
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список расходных накладных
            </div>
            <a href="{{ route('outgoing-orders.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новая накладная
            </a>
        </div>
        <div class="card-body">
            <!-- Фильтры -->
            <div class="filter-box">
                <form method="GET" action="{{ route('outgoing-orders.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Номер или клиент">
                        </div>
                        <div class="form-group">
                            <label>Статус</label>
                            <select name="status" class="form-control">
                                <option value="">Все</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Резерв</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Отгружен</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Отменен</option>
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
                            <th>Номер</th>
                            <th>Дата</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Создал</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->number }}</td>
                                <td>{{ $order->order_date->format('d.m.Y') }}</td>
                                <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                <td>
                                    @switch($order->status)
                                        @case('draft')
                                            <span class="badge badge-warning">Черновик</span>
                                            @break
                                        @case('reserved')
                                            <span class="badge badge-info">Резерв</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge badge-success">Отгружен</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Отменен</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('outgoing-orders.show', $order) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($order->status == 'draft')
                                            <form action="{{ route('outgoing-orders.destroy', $order) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Удалить">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">Накладные не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection