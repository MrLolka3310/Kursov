@extends('layouts.app')

@section('title', 'Пользователи')

@section('page-title')
    <i class="fas fa-users-cog"></i>
    Управление пользователями
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-list"></i>
                Список пользователей
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Новый пользователь
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @switch($user->role)
                                        @case('admin')
                                            <span class="badge badge-danger">Администратор</span>
                                            @break
                                        @case('manager')
                                            <span class="badge badge-primary">Менеджер</span>
                                            @break
                                        @case('storekeeper')
                                            <span class="badge badge-success">Кладовщик</span>
                                            @break
                                        @case('analyst')
                                            <span class="badge badge-info">Аналитик</span>
                                            @break
                                        @case('accountant')
                                            <span class="badge badge-warning">Бухгалтер</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Пользователи не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection