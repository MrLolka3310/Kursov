@extends('layouts.app')

@section('title', 'Поставщики')

@section('page-title')
    <i class="fas fa-truck"></i>
    Поставщики
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список поставщиков
            </div>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новый поставщик
            </a>
        </div>
        <div class="card-body">
            <div class="filter-box">
                <form method="GET" action="{{ route('suppliers.index') }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Поиск</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Название, контакт, email">
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
                            <th>Название</th>
                            <th>Контактное лицо</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>ИНН</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td><strong>{{ $supplier->name }}</strong></td>
                                <td>{{ $supplier->contact_person ?? '-' }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->inn ?? '-' }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display: inline;">
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
                                <td colspan="6" style="text-align: center;">Поставщики не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $suppliers->links() }}
            </div>
        </div>
    </div>
@endsection