@extends('layouts.app')

@section('title', 'Клиенты')

@section('page-title')
    <i class="fas fa-users"></i>
    Клиенты
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список клиентов
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новый клиент
            </a>
        </div>
        <div class="card-body">
            <div class="filter-box">
                <form method="GET" action="{{ route('customers.index') }}">
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
                            <th>Тип</th>
                            <th>Скидка</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td><strong>{{ $customer->name }}</strong></td>
                                <td>{{ $customer->contact_person ?? '-' }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    @if($customer->customer_type == 'legal')
                                        <span class="badge badge-info">Юр. лицо</span>
                                    @else
                                        <span class="badge badge-success">Физ. лицо</span>
                                    @endif
                                </td>
                                <td>{{ $customer->discount }}%</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-outline" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display: inline;">
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
                                <td colspan="7" style="text-align: center;">Клиенты не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection