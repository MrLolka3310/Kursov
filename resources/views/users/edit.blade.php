@extends('layouts.app')

@section('title', 'Редактирование пользователя')

@section('page-title')
    <i class="fas fa-edit"></i>
    Редактирование пользователя: {{ $user->name }}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <i class="fas fa-user-edit"></i>
                Редактирование пользователя
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i>
                Назад
            </a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Имя пользователя *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Новый пароль (оставьте пустым, если не хотите менять)</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <small style="color: var(--danger-color);">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Подтверждение нового пароля</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Роль *</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">Выберите роль</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Администратор</option>
                        <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Менеджер</option>
                        <option value="storekeeper" {{ old('role', $user->role) == 'storekeeper' ? 'selected' : '' }}>Кладовщик</option>
                        <option value="analyst" {{ old('role', $user->role) == 'analyst' ? 'selected' : '' }}>Аналитик</option>
                        <option value="accountant" {{ old('role', $user->role) == 'accountant' ? 'selected' : '' }}>Бухгалтер</option>
                    </select>
                    @error('role')
                        <small style="color: var(--danger-color);">{{ $message }}</small>
                    @enderror
                </div>
                
                <hr>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Сохранить изменения
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i>
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection