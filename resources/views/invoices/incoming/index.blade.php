@extends('layouts.app')

@section('title', 'Приходные накладные')

@section('page-title')
    <i class="fas fa-truck"></i>
    Приходные накладные
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список приходных накладных
            </div>
            <a href="{{ route('incoming-invoices.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новая накладная
            </a>
        </div>
        <div class="card-body">
            <!-- Фильтры -->
            <div class="filter-box">
                <form method="GET" action="{{ route('incoming-invoices.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Номер или поставщик">
                        </div>
                        <div class="form-group">
                            <label>Статус</label>
                            <select name="status" class="form-control">
                                <option value="">Все</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновик</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Проведен</option>
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
                            <th>Поставщик</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Создал</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->number }}</td>
                                <td>{{ $invoice->invoice_date->format('d.m.Y') }}</td>
                                <td>{{ $invoice->supplier->name ?? 'N/A' }}</td>
                                <td>{{ number_format($invoice->total_amount, 2, ',', ' ') }} ₽</td>
                                <td>
                                    @switch($invoice->status)
                                        @case('draft')
                                            <span class="badge badge-warning">Черновик</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-success">Проведен</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Отменен</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $invoice->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('incoming-invoices.show', $invoice) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($invoice->status == 'draft')
                                            <form action="{{ route('incoming-invoices.destroy', $invoice) }}" method="POST" style="display: inline;">
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
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
@endsection