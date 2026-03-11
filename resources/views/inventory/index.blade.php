@extends('layouts.app')

@section('title', 'Инвентаризация')

@section('page-title')
    <i class="fas fa-clipboard-list"></i>
    Инвентаризация
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список инвентаризаций
            </div>
            <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новая инвентаризация
            </a>
        </div>
        <div class="card-body">
            <div class="filter-box">
                <form method="GET" action="{{ route('inventory.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Номер документа">
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
                            <th>Номер</th>
                            <th>Дата</th>
                            <th>Количество позиций</th>
                            <th>Расхождений</th>
                            <th>Статус</th>
                            <th>Ответственный</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventories as $inventory)
                            @php
                                $itemsCount = $inventory->items()->count();
                                $discrepancies = $inventory->items()->where('difference', '!=', 0)->count();
                            @endphp
                            <tr>
                                <td><strong>{{ $inventory->number }}</strong></td>
                                <td>{{ $inventory->inventory_date->format('d.m.Y') }}</td>
                                <td>{{ $itemsCount }}</td>
                                <td>
                                    @if($discrepancies > 0)
                                        <span class="badge badge-warning">{{ $discrepancies }}</span>
                                    @else
                                        <span class="badge badge-success">0</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($inventory->status)
                                        @case('draft')
                                            <span class="badge badge-warning">Черновик</span>
                                            @break
                                        @case('completed')
                                            <span class="badge badge-success">Проведена</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Отменена</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">Инвентаризации не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $inventories->links() }}
            </div>
        </div>
    </div>
@endsection