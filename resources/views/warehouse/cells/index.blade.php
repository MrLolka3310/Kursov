@extends('layouts.app')

@section('title', 'Ячейки склада')

@section('page-title')
    <i class="fas fa-warehouse"></i>
    Ячейки склада
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список ячеек
            </div>
            <a href="{{ route('warehouse-cells.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новая ячейка
            </a>
        </div>
        <div class="card-body">
            <div class="filter-box">
                <form method="GET" action="{{ route('warehouse-cells.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Код ячейки, зона">
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
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Код</th>
                            <th>Зона</th>
                            <th>Стеллаж</th>
                            <th>Полка</th>
                            <th>Текущий остаток</th>
                            <th>Макс. нагрузка</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cells as $cell)
                            <tr>
                                <td><strong>{{ $cell->code }}</strong></td>
                                <td>{{ $cell->zone ?? '-' }}</td>
                                <td>{{ $cell->rack ?? '-' }}</td>
                                <td>{{ $cell->shelf ?? '-' }}</td>
                                <td>{{ number_format($cell->current_stock, 3, ',', ' ') }}</td>
                                <td>{{ $cell->max_weight ? $cell->max_weight . ' кг' : '-' }}</td>
                                <td>
                                    @if($cell->is_active)
                                        <span class="badge badge-success">Активна</span>
                                    @else
                                        <span class="badge badge-danger">Неактивна</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('warehouse-cells.show', $cell) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('warehouse-cells.edit', $cell) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('warehouse-cells.destroy', $cell) }}" method="POST" style="display: inline;">
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
                                <td colspan="8" style="text-align: center;">Ячейки не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $cells->links() }}
            </div>
        </div>
    </div>
@endsection